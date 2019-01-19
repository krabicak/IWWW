<?php

class Controller
{
    private $userDao;
    private $brandsDao;
    private $categoryDao;
    private $productsDao;
    private $ordersDao;
    static private $instance = NULL;
    static private $auth = NULL;
    static private $basket = NULL;

    static public $product;

    static function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new Controller();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->userDao = new UserDao(Connection::getPdoInstance());
        $this->brandsDao = new BrandsDao(Connection::getPdoInstance());
        $this->categoryDao = new CategoryDao(Connection::getPdoInstance());
        $this->productsDao = new ProductsDao(Connection::getPdoInstance());
        $this->ordersDao = new OrdersDao(Connection::getPdoInstance());
        static::$auth = Authentication::getInstance();
        static::$basket = BasketHelper::getInstance();
    }

    public function login()
    {
        if (isset($_POST["login-email"]) && $_POST["password"]) {
            if (filter_var($_POST["login-email"], FILTER_VALIDATE_EMAIL)) {
                if (static::$auth->login($_POST["login-email"], $_POST["password"])) {
                    header("Refresh:0");
                } else {
                    echo "<script>$(document).ready(function(){alert('Špatně zadané údaje');});</script>";
                }
            }
        }
    }

    public function isUserLogged()
    {
        return static::$auth->getIdentity() != NULL;
    }

    public function isUserAdmin()
    {
        return ($this->isUserLogged() && static::$auth->getIdentity()->getRole() == "admin");
    }

    public function isUserManager()
    {
        return ($this->isUserLogged() && static::$auth->getIdentity()->getRole() == "manager" || $this->isUserAdmin());
    }

    public function logout()
    {
        static::$auth->logout();
        header("location: " . BASE_URL);
        exit();
    }

    public function navigation()
    {
        if (isset($_GET["page"])) {
            if (file_exists("page/" . $_GET["page"] . ".php")) {
                require_once "page/" . $_GET["page"] . ".php";
            } else {
                header("location:" . BASE_URL . "?page=products");
            }
        } else {
            header("location:" . BASE_URL . "?page=products");
        }
    }

    private function showUsers($users)
    {
        echo "<table>";
        echo "<tr><td>id</td><td>email</td><td>jméno</td><td>příjmení</td><td>adresa</td><td>role</td><td>deaktivovat</td><td>akce</td></tr>";
        foreach ($users as $user) {
            $user->setRoles(Role::getArray());
            echo $user->render();
        }
        echo "</table>";
    }

    public function userManagement()
    {
        if (isset($_POST["action"])) {
            if ($_POST["action"] == "by-email") {
                $users = $this->userDao->getByEmail($_POST["email"]);
                echo "<h2>Výsledky vyhledávání:</h2>";
                $this->showUsers($users);
            } elseif ($_POST["action"] == 'remove-user') {
                $this->userDao->deleteUser($_POST["id"]);
                header("Refresh:0");
            } elseif ($_POST["action"] == 'update-user') {
                if (isset($_POST["disabled"]) && $_POST["disabled"] == 1)
                    $this->userDao->updateUser($_POST["id"], $_POST["email"], $_POST["role"], $_POST["first-name"], $_POST["last-name"], $_POST["address"], 1);
                else $this->userDao->updateUser($_POST["id"], $_POST["email"], $_POST["role"], $_POST["first-name"], $_POST["last-name"], $_POST["address"], 0);
                header("Refresh:0");
            }
        } else {
            $users = $this->userDao->getAllUsers();
            $this->showUsers($users);
        }
    }

    public function register()
    {
        if (isset($_POST["email"]) && $_POST["password"] && $_POST["password-again"]) {
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                if ($_POST["password"] == $_POST["password"]) {
                    $this->userDao->addUser($_POST['email'], 'user', password_hash($_POST['password'], PASSWORD_BCRYPT));
                    echo "<script>$(document).ready(function(){alert('Uživatel úspěšně registrován!');});</script>";
                } else echo "<script>$(document).ready(function(){alert('Hesla se neshodují');});</script>";
            } else echo "<script>$(document).ready(function(){alert('Je třeba zadat emailovou adresu');});</script>";
        }
    }

    private function showBrands($brands)
    {
        echo "<table>";
        echo "<tr><td>název</td><td>akce</td></tr>";
        echo "<tr><form method='post' name='action'><td><input type='text' name='brand'></td><td><button name='action' type='submit' value='add-brand'>přidat</button></td></form></tr>";
        foreach ($brands as $brand) {
            echo $brand->render();
        }
        echo "</table>";
    }

    public function brandsManagement()
    {
        if (isset($_POST["action"])) {
            if ($_POST["action"] == "by-brand") {
                $brands = $this->brandsDao->getByBrand($_POST["brand"]);
                echo "<h2>Výsledky vyhledávání:</h2>";
                $this->showBrands($brands);
            } elseif ($_POST["action"] == 'remove-brand') {
                $this->brandsDao->deleteBrand($_POST["id"]);
                header("Refresh:0");
            } elseif ($_POST["action"] == 'update-brand') {
                $this->brandsDao->updateBrand($_POST["id"], $_POST["brand"]);
                header("Refresh:0");
            } elseif ($_POST["action"] == 'add-brand') {
                $this->brandsDao->addBrand($_POST["brand"]);
                header("Refresh:0");
            }
        } else {
            $brands = $this->brandsDao->getAllBrands();
            $this->showBrands($brands);
        }
    }

    private function showCategories($categories)
    {
        echo "<table>";
        echo "<tr><td>název</td><td>deaktivovat</td><td>akce</td></tr>";
        echo "<tr><form method='post' name='action'><td><input type='text' name='category'></td><td></td><td><button name='action' type='submit' value='add-category'>přidat</button></td></form></tr>";
        foreach ($categories as $category) {
            echo $category->render();
        }
        echo "</table>";
    }

    public function categoryManagement()
    {
        if (isset($_POST["action"])) {
            if ($_POST["action"] == "by-category") {
                $categories = $this->categoryDao->getByCategories($_POST["category"]);
                echo "<h2>Výsledky vyhledávání:</h2>";
                $this->showCategories($categories);
            } elseif ($_POST["action"] == 'remove-category') {
                $this->categoryDao->deleteCategory($_POST["id"]);
                header("Refresh:0");
            } elseif ($_POST["action"] == 'update-category') {
                if (isset($_POST["disabled"]) && $_POST["disabled"] == 1)
                    $this->categoryDao->updateCategory($_POST["id"], $_POST["category"], 1);
                else
                    $this->categoryDao->updateCategory($_POST["id"], $_POST["category"], 0);
                header("Refresh:0");
            } elseif ($_POST["action"] == 'add-category') {
                $this->categoryDao->addCategory($_POST["category"]);
                header("Refresh:0");
            }
        } else {
            $categories = $this->categoryDao->getAllCategories();
            $this->showCategories($categories);
        }
    }

    public function categories()
    {
        $categories = $this->categoryDao->getAllCategories();
        foreach ($categories as $category) {
            if ($category->getDisabled() == 1) continue;
            echo "<a href='" . BASE_URL . "?page=products&category=" . $category->getCategory() . "'>" . $category->getCategory() . "</a>";
        }
    }

    public
    function getLoggedUserFirstName()
    {
        if ($this->isUserLogged()) {
            return static::$auth->getIdentity()->getFirstName();
        }
    }

    public
    function getLoggedUserId()
    {
        if ($this->isUserLogged()) {
            return static::$auth->getIdentity()->getId();
        }
    }

    public
    function getLoggedUserLastName()
    {
        if ($this->isUserLogged()) {
            return static::$auth->getIdentity()->getLastName();
        }
    }

    public
    function getLoggedUserEmail()
    {
        if ($this->isUserLogged()) {
            return static::$auth->getIdentity()->getEmail();
        }
    }

    public
    function getLoggedUserAddress()
    {
        if ($this->isUserLogged()) {
            return static::$auth->getIdentity()->getAddress();
        }
    }

    public
    function getLoggedUserName()
    {
        if ($this->getLoggedUserFirstName() . ' ' . $this->getLoggedUserLastName() == " ") {
            return $this->getLoggedUserEmail();
        } else return $this->getLoggedUserFirstName() . ' ' . $this->getLoggedUserLastName();
    }

    public
    function changeUser()
    {
        if (isset($_POST["action"])) {
            if ($_POST["action"] == "save") {
                $this->userDao->updateUser(static::$auth->getIdentity()->getId(), $_POST["email"], static::$auth->getIdentity()->getRole(),
                    $_POST["first-name"], $_POST["last-name"], $_POST["address"], 0);
                static::$auth->reload();
                echo "<script>$(document).ready(function(){alert('Uloženo.');});</script>";
            } elseif ($_POST["action"] == "change") {
                if (static::$auth->isPasswordCorrect($_POST["actual-password"])) {
                    if (strlen($_POST["new-password"]) > 8) {
                        if ($_POST["new-password"] == $_POST["new-password-again"]) {
                            $this->userDao->changePassword(static::$auth->getIdentity()->getId(), password_hash($_POST['new-password'], PASSWORD_BCRYPT));
                            static::$auth->reload();
                            echo "<script>$(document).ready(function(){alert('Heslo změněno');});</script>";
                        } else echo "<script>$(document).ready(function(){alert('Zadaná hesla se neshodují');});</script>";
                    } else echo "<script>$(document).ready(function(){alert('Zadané heslo je příliš krátké');});</script>";
                } else echo "<script>$(document).ready(function(){alert('Špatně zadané aktuální heslo');});</script>";
            }
            unset($_POST["action"]);
        }
    }

    private function isCategoryDisabled($category)
    {
        return $this->categoryDao->isCategoryDisabled($category);
    }

    private
    function showProducts($products)
    {
        function costDESC($a, $b)
        {
            return $a->getCost() < $b->getCost();
        }

        function costASC($a, $b)
        {
            return $a->getCost() > $b->getCost();
        }

        function createdDESC($a, $b)
        {
            return $a->getCreated() < $b->getCreated();
        }

        function createdASC($a, $b)
        {
            return $a->getCreated() > $b->getCreated();
        }

        if (isset($_POST["sort"]) && $_POST["sort"] == "costDESC") usort($products, "costDESC");
        if (isset($_POST["sort"]) && $_POST["sort"] == "costASC") usort($products, "costASC");
        if (isset($_POST["sort"]) && $_POST["sort"] == "createdDESC") usort($products, "createdDESC");
        if (isset($_POST["sort"]) && $_POST["sort"] == "createdASC") usort($products, "createdASC");
        $counter = 0;
        foreach ($products as $product) {
            if ($product->getDisabled() == 1 || $this->isCategoryDisabled($product->getCategory())) continue;
            if ($product->getCategory())
                echo $product->show();
            $counter++;
        }
        if ($counter == 0) echo "<h2 id='nothing-to-show'>Nic nenalezeno</h2>";
    }

    public
    function showAllProducts()
    {
        if (isset($_POST["action"]) && $_POST["action"] == "show-by-filters" && !$_POST["brand"] == "") {
            $this->showProducts($this->productsDao->getProductsByBrand($_POST["brand"]));
        } else
            $this->showProducts($this->productsDao->getAllProducts());

    }

    public
    function showProductsByCategory()
    {
        if (isset($_POST["action"]) && $_POST["action"] == "show-by-filters" && !$_POST["brand"] == "") {
            $this->showProducts($this->productsDao->getProductsByCategoryAndBrand($_GET["category"], $_POST["brand"]));
        } else
            $this->showProducts($this->productsDao->getProductsByCategory($_GET["category"]));
    }

    private
    function showProductsOfManagement($brands, $categories, $products)
    {
        echo "<table>";
        echo "<tr><td>id</td><td>vytvořeno</td><td>název</td><td>značka</td><td>kategorie</td><td>skladem</td><td>obrázek</td><td>cena</td><td>deaktivovat</td><td>akce</td></tr>";
        echo "<tr><td>id</td><td>vytvořeno</td><form method='post' name='action'><td><input type='text' name='product'></td>";
        echo "<td><select name='brand'>";
        foreach ($brands as $brand) {
            echo "<option value='" . $brand->getBrand() . "'>" . $brand->getBrand() . "</option>";
        }
        echo "</select></td>";
        echo "<td><select name='category'>";
        foreach ($categories as $category) {
            if ($category->getDisabled() == 1) continue;
            echo "<option value='" . $category->getCategory() . "'>" . $category->getCategory() . "</option>";
        }
        echo "</select></td>";
        echo "<td><input type='text' name='stock' value='0'></td>";
        echo "<td><input type='text' name='image-link' value=''></td>";
        echo "<td><input type='text' name='cost' value='0'></td>";
        echo "<td></td>";
        echo "<td><button name='action' type='submit' value='add-product'>přidat</button></td></form></tr>";
        foreach ($products as $product) {
            $product->setCategories($categories);
            $product->setBrands($brands);
            echo $product->render();
        }
        echo "</table>";
    }

    public
    function productsManagement()
    {
        $categories = $this->categoryDao->getAllCategories();
        $brands = $this->brandsDao->getAllBrands();
        $products = $this->productsDao->getAllProducts();

        if (isset($_POST["action"])) {
            if ($_POST["action"] == "upload-image") {
                IO::uploadFile();
            } elseif ($_POST["action"] == "edit-description") {
                header("location: " . BASE_URL . "?page=edit-description&product=" . $_POST["id"]);
            } elseif ($_POST["action"] == "by-id") {
                echo "<h2>Výsledky vyhledávání:</h2>";
                $products = $this->productsDao->getProductById($_POST["id"]);
            } elseif ($_POST["action"] == "by-name") {
                echo "<h2>Výsledky vyhledávání:</h2>";
                $products = $this->productsDao->getProductsByName($_POST["name"]);
            } elseif ($_POST["action"] == "add-product") {
                $this->productsDao->addProduct($_POST["product"], $_POST["image-link"], $_POST["stock"], $_POST["brand"], $_POST["category"], $_POST["cost"]);
                header("Refresh:0");
            } elseif ($_POST["action"] == "update-product") {
                if (isset($_POST["disabled"]) && $_POST["disabled"] == 1)
                    $this->productsDao->updateProduct($_POST["id"], $_POST["name"], $_POST["image-link"], $_POST["stock"], $_POST["brand"], $_POST["category"], $_POST["cost"], 1);
                else $this->productsDao->updateProduct($_POST["id"], $_POST["name"], $_POST["image-link"], $_POST["stock"], $_POST["brand"], $_POST["category"], $_POST["cost"], 0);
                header("Refresh:0");
            } elseif ($_POST["action"] == "export") {
                $file = "export/export.json";
                file_put_contents($file, json_encode($products));
            } elseif ($_POST["action"] == "import") {
                $string = file_get_contents(IO::importJSON());
                $arr = json_decode($string, true);
                foreach ($arr as $item) {
                    $this->productsDao->addProduct(
                        $item["name"],
                        $item["image"],
                        $item["stock"],
                        $item["brand"],
                        $item["category"],
                        $item["cost"]);
                }
                header("Refresh:0");
            }
        }

        $this->showProductsOfManagement($brands, $categories, $products);

    }

    public function getProduct($id)
    {
        return $this->productsDao->getProductById($id)[0];
    }

    public
    function editDescription()
    {
        if (isset($_POST["action"])) {
            if ($_POST["action"] == "save-description") {
                $this->productsDao->updateDescriptionOfProduct($_GET["product"], $_POST["editor"]);
                header("location: " . BASE_URL . "?page=product-management");
            }
        }
    }

    public
    function getAllBrands()
    {
        return $this->brandsDao->getAllBrands();
    }

    public
    function getAllCategories()
    {
        return $this->categoryDao->getAllCategories();
    }

    public
    function showFilter()
    {
        foreach ($this->getAllBrands() as $brand) {
            echo "<option value='" . $brand->getBrand() . "'";
            if (isset($_POST["action"]) && $_POST["action"] == "show-by-filters" && $_POST["brand"] == $brand->getBrand()) echo "selected='selected'";
            echo ">" . $brand->getBrand() . "</option>";
        }
        echo '</select>';
        echo '&nbsp;Třídit podle : <select name="sort">';
        echo '<option value = "createdDESC"';
        if (isset($_POST["sort"]) && $_POST["sort"] == "createdDESC") echo 'selected="selected"';
        echo '>Nejnovější</option><option value="costASC"';
        if (isset($_POST["sort"]) && $_POST["sort"] == "costASC") echo 'selected="selected"';
        echo '>Nejlevnější</option><option value = "costDESC"';
        if (isset($_POST["sort"]) && $_POST["sort"] == "costDESC") echo 'selected="selected"';
        echo '>Nejdražší</option><option value = "createdASC"';
        if (isset($_POST["sort"]) && $_POST["sort"] == "createdASC") echo 'selected="selected"';
        echo '>Nejstarší</option>';
    }

    public
    function showResults()
    {
        echo '<h2>Výsledky pro "' . $_GET["q"] . '":</h2>';
    }

    public
    function searchProducts()
    {
        if (isset($_GET["q"])) {
            if (isset($_POST["action"]) && $_POST["action"] == "show-by-filters" && !$_POST["brand"] == "") {
                $this->showProducts($this->productsDao->searchProductsWithBrand($_GET["q"], $_POST["brand"]));
            } else
                $this->showProducts($this->productsDao->searchProducts($_GET["q"]));
        }
    }

    public
    function addProductToBasket()
    {
        $arr = $this->productsDao->getProductById($_POST["add-to-basket"]);
        if (isset($arr[0])) {
            static::$basket->addProduct($arr[0]);
            echo "<script>$(document).ready(function(){alert('Produkt " . $arr[0]->getName() . " přidán do košíku!');});</script>";
        }
    }

    public
    function basket()
    {
        if (isset($_POST["action"])) {
            if ($_POST["action"] == "remove-product") {
                self::$basket->removeProduct($_POST["id"]);
                header("Refresh:0");
            } elseif ($_POST["action"] == "buy") {
                $sum = 0;
                foreach (static::$basket->getProducts() as $id) {
                    $product = $this->productsDao->getProductById($id)[0];
                    $sum += $product->getCost();
                    echo $product->renderInBasket();
                }
                $this->ordersDao->addOrder($_POST["info"],
                    $_POST["first-name"] . " " . $_POST["last-name"] . ", " . $_POST["address"],
                    State::getProcessing()->getState(), $this->getLoggedUserId(),
                    static::$basket->getProducts(), $sum);
                self::$basket->removeAllProducts();
                echo "<script>alert('Objednávka úspěšně vytvořena!')</script>";
                header("Refresh:0");
            }
        }
        if (static::$basket->getProducts() != null) {
            $sum = 0;
            echo "<table>";
            echo "<tr><td></td><td>název</td><td class='right'>skladem</td><td class='right'>cena</td></tr>";
            foreach (static::$basket->getProducts() as $id) {
                $product = $this->productsDao->getProductById($id)[0];
                $sum += $product->getCost();
                echo $product->renderInBasket();
            }
            echo "<tr><td></td><td></td><td>Celkem: </td><td class='total'>$sum Kč</td></tr>";
            echo "</table>";
        } else {
            echo "<h2 id='nothing-to-show'>prázdný</h2>";
        }
    }

    public function isBasketEmpty()
    {
        return self::$basket->getSize() == 0;
    }

    public function myOrders()
    {
        if (isset($_POST["action"])) {
            if ($_POST["action"] == "cancel-order") {
                $this->ordersDao->cancelOrder($_POST["id"]);
            }
        }
        $orders = $this->ordersDao->getAllOrdersByUser($this->getLoggedUserId(), $this->productsDao);
        foreach ($orders as $order) {
            echo "<form method='post'><table>";
            echo $order->renderInMyOrders($this->ordersDao->getCostsIdOrder($order->getId()));
            echo "</table></form>";
        }
    }

    public static function setProduct($product)
    {
        if ($product == NULL) {
            header("location: " . BASE_URL);
        }
        self::$product = $product;
    }

    private function showOrders($orders)
    {
        foreach ($orders as $order) {
            echo "<table>";
            echo $order->render($this->ordersDao->getCostsIdOrder($order->getId()), $this->userDao->getById($order->getUsersId()));
            echo "</table>";
        }
    }

    public function ordersManagement()
    {
        if (isset($_POST["action"])) {
            if ($_POST["action"] == "cancel-order") {
                $this->ordersDao->cancelOrder($_POST["id"]);
            } elseif ($_POST["action"] == "send-order") {
                $this->ordersDao->sendOrder($_POST["id"]);
            } elseif ($_POST["action"] == "by-id") {
                $orders = $this->ordersDao->getById($this->productsDao, $_POST["id"]);
                echo "<h2>Výsledky vyhledávání:</h2>";
                $this->showOrders($orders);
            } elseif ($_POST["action"] == "by-email") {
                $users = $this->userDao->getByEmail($_POST["email"]);
                echo "<h2>Výsledky vyhledávání:</h2>";
                foreach ($users as $user) {
                    $orders = $this->ordersDao->getAllOrdersByUser($user->getId(), $this->productsDao);
                    $this->showOrders($orders);
                }
            }
        } else {
            $orders = $this->ordersDao->getAllOrders($this->productsDao);
            $this->showOrders($orders);
        }
    }
}

?>