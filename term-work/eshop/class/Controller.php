<?php

class Controller
{
    private $userDao;
    private $brandsDao;
    private $categoryDao;
    private $productsDao;
    static private $instance = NULL;
    static private $auth = NULL;

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
        static::$auth = Authentication::getInstance();
    }

    public function login()
    {
        if (isset($_POST["login-email"]) && $_POST["password"]) {
            if (filter_var($_POST["login-email"], FILTER_VALIDATE_EMAIL)) {
                if (static::$auth->login($_POST["login-email"], $_POST["password"])) {
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    echo "<script>alert('User not found!')</script>";
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
        if (isset($_GET["q"])) {
            require_once "page/search-page.php";
        } else
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
        echo "<tr><td>ID</td><td>email</td><td>first name</td><td>last name</td><td>address</td><td>role</td><td>actions</td></tr>";
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
                echo "<h2>Users by email</h2>";
                $this->showUsers($users);

            } else {
                $user = explode(':', $_POST["action"], 2);
                if ($user[0] == 'remove-user') {
                    $this->userDao->deleteUser($user[1]);
                    unset($_POST["action"]);
                    header("Refresh:0");
                } elseif ($user[0] == 'update-user') {
                    $this->userDao->updateUser($user[1], $_POST["email"], $_POST["role"], $_POST["first-name"], $_POST["last-name"], $_POST["address"]);
                    unset($_POST["action"]);
                    header("Refresh:0");
                }
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
                    echo "<script>alert('User registered!')</script>";
                } else echo "<script>alert('Passwords doesn\'t match')</script>";
            } else echo "<script>alert('Bad email')</script>";
        }
    }

    private function showBrands($brands)
    {
        echo "<table>";
        echo "<tr><td>name</td><td>actions</td></tr>";
        echo "<tr><form method='post' name='action'><td><input type='text' name='brand'></td><td><button name='action' type='submit' value='add-brand'>add</button></td></form></tr>";
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
                echo "<h2>Brands by name</h2>";
                $this->showBrands($brands);
            } else {
                $brand = explode(':', $_POST["action"], 2);
                if ($brand[0] == 'remove-brand') {
                    $this->brandsDao->deleteBrand($brand[1]);
                    unset($_POST["action"]);
                    header("Refresh:0");
                } elseif ($brand[0] == 'update-brand') {
                    $this->brandsDao->updateBrand($brand[1], $_POST["brand"]);
                    unset($_POST["action"]);
                    header("Refresh:0");
                } elseif ($brand[0] == 'add-brand') {
                    $this->brandsDao->addBrand($_POST["brand"]);
                    unset($_POST["action"]);
                    header("Refresh:0");
                }
            }
        } else {
            $brands = $this->brandsDao->getAllBrands();
            $this->showBrands($brands);
        }
    }

    private function showCategories($categories)
    {
        echo "<table>";
        echo "<tr><td>name</td><td>actions</td></tr>";
        echo "<tr><form method='post' name='action'><td><input type='text' name='category'></td><td><button name='action' type='submit' value='add-category'>add</button></td></form></tr>";
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
                echo "<h2>Categories by name</h2>";
                $this->showCategories($categories);
            } else {
                $category = explode(':', $_POST["action"], 2);
                if ($category[0] == 'remove-category') {
                    $this->categoryDao->deleteCategory($category[1]);
                    unset($_POST["action"]);
                    header("Refresh:0");
                } elseif ($category[0] == 'update-category') {
                    $this->categoryDao->updateCategory($category[1], $_POST["category"]);
                    unset($_POST["action"]);
                    header("Refresh:0");
                } elseif ($category[0] == 'add-category') {
                    $this->categoryDao->addCategory($_POST["category"]);
                    unset($_POST["action"]);
                    header("Refresh:0");
                }
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
            echo "<a href='" . BASE_URL . "?page=products&category=" . $category->getCategory() . "'>" . $category->getCategory() . "</a>";
        }
    }

    public function getLoggedUserFirstName()
    {
        if ($this->isUserLogged()) {
            return static::$auth->getIdentity()->getFirstName();
        }
    }

    public function getLoggedUserLastName()
    {
        if ($this->isUserLogged()) {
            return static::$auth->getIdentity()->getLastName();
        }
    }

    public function getLoggedUserEmail()
    {
        if ($this->isUserLogged()) {
            return static::$auth->getIdentity()->getEmail();
        }
    }

    public function getLoggedUserAddress()
    {
        if ($this->isUserLogged()) {
            return static::$auth->getIdentity()->getAddress();
        }
    }

    public function getLoggedUserName()
    {
        if ($this->getLoggedUserFirstName() . ' ' . $this->getLoggedUserLastName() == " ") {
            return $this->getLoggedUserEmail();
        } else return $this->getLoggedUserFirstName() . ' ' . $this->getLoggedUserLastName();
    }

    public function changeUser()
    {
        if (isset($_POST["action"])) {
            if ($_POST["action"] == "save") {
                $this->userDao->updateUser(static::$auth->getIdentity()->getId(), $_POST["email"], static::$auth->getIdentity()->getRole(),
                    $_POST["first-name"], $_POST["last-name"], $_POST["address"]);
                static::$auth->reload();
            } elseif ($_POST["action"] == "change") {
                if (static::$auth->isPasswordCorrect($_POST["actual-password"])) {
                    if (strlen($_POST["new-password"]) > 8) {
                        if ($_POST["new-password"] == $_POST["new-password-again"]) {
                            $this->userDao->changePassword(static::$auth->getIdentity()->getId(), password_hash($_POST['new-password'], PASSWORD_BCRYPT));
                            static::$auth->reload();
                        } else echo "<script>alert(\"Passwords do not match\")</script>";
                    } else echo "<script>alert(\"Password is too short\")</script>";
                } else echo "<script>alert(\"Bad password\")</script>";
            }
            unset($_POST["action"]);
        }
    }

    private function showProducts($products)
    {
        function costDESC($a, $b)
        {
            return $a->getCost() > $b->getCost();
        }

        function costASC($a, $b)
        {
            return $a->getCost() < $b->getCost();
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
        if (empty($products)) echo "<h2 id='nothing-to-show'>Nothing to show</h2>";
        else
            foreach ($products as $product) {
                echo $product->show();
            }
    }

    public function showAllProducts()
    {
        if (isset($_POST["action"]) && $_POST["action"] == "show-by-filters" && !$_POST["brand"] == "") {
            $this->showProducts($this->productsDao->getProductsByBrand($_POST["brand"]));
        } else
            $this->showProducts($this->productsDao->getAllProducts());

    }

    public function showProductsByCategory()
    {
        if (isset($_POST["action"]) && $_POST["action"] == "show-by-filters" && !$_POST["brand"] == "") {
            $this->showProducts($this->productsDao->getProductsByCategoryAndBrand($_GET["category"], $_POST["brand"]));
        } else
            $this->showProducts($this->productsDao->getProductsByCategory($_GET["category"]));
    }

    private function showProductsOfManagement($brands, $categories, $products)
    {
        echo "<table>";
        echo "<tr><td>id</td><td>created</td><td>name</td><td>brand</td><td>category</td><td>stock</td><td>image link</td><td>cost</td><td>actions</td></tr>";
        echo "<tr><td>id</td><td>created</td><form method='post' name='action'><td><input type='text' name='product'></td>";
        echo "<td><select name='brand'>";
        foreach ($brands as $brand) {
            echo "<option value='" . $brand->getBrand() . "'>" . $brand->getBrand() . "</option>";
        }
        echo "</select></td>";
        echo "<td><select name='category'>";
        foreach ($categories as $category) {
            echo "<option value='" . $category->getCategory() . "'>" . $category->getCategory() . "</option>";
        }
        echo "</select></td>";
        echo "<td><input type='text' name='stock' value='0'></td>";
        echo "<td><input type='text' name='image-link' value=''></td>";
        echo "<td><input type='text' name='cost' value='0'></td>";
        echo "<td><button name='action' type='submit' value='add-product'>add</button></td></form></tr>";
        foreach ($products as $product) {
            $product->setCategories($categories);
            $product->setBrands($brands);
            echo $product->render();
        }
        echo "</table>";
    }

    public function productsManagement()
    {

        $categories = $this->categoryDao->getAllCategories();
        $brands = $this->brandsDao->getAllBrands();
        $products = $this->productsDao->getAllProducts();

        if (isset($_POST["action"])) {
            $product = explode(':', $_POST["action"], 2);
            if ($product[0] == "upload-image") {
                ImageHelper::uploadFile();
            } elseif ($product[0] == "edit-description") {
                header("location: " . BASE_URL . "?page=edit-description&product=" . $product[1]);
            } elseif ($product[0] == "by-id") {
                echo "<h2>Product by id</h2>";
                $products = $this->productsDao->getProductById($_POST["id"]);
            } elseif ($product[0] == "by-name") {
                echo "<h2>Products by name</h2>";
                $products = $this->productsDao->getProductsByName($_POST["name"]);
            } elseif ($product[0] == "add-product") {
                $this->productsDao->addProduct($_POST["product"], $_POST["image-link"], $_POST["stock"], $_POST["brand"], $_POST["category"], $_POST["cost"]);
                unset($_POST["action"]);
                header("Refresh:0");
            } elseif ($product[0] == "update-product") {
                $this->productsDao->updateProduct($product[1], $_POST["name"], $_POST["image-link"], $_POST["stock"], $_POST["brand"], $_POST["category"], $_POST["cost"]);
                unset($_POST["action"]);
                header("Refresh:0");
            }
        }

        $this->showProductsOfManagement($brands, $categories, $products);

    }

    public function getDescriptionOfProduct($id)
    {
        if (isset($this->productsDao->getProductById($id)[0])) {
            return $this->productsDao->getProductById($id)[0]->getDescription();
        } else return "";
    }

    public function editDescription()
    {
        if (isset($_POST["action"])) {
            if ($_POST["action"] == "save-description") {
                $this->productsDao->updateDescriptionOfProduct($_GET["product"], $_POST["editor"]);
                header("location: " . BASE_URL . "?page=product-management");
            }
        }
    }

    public function getAllBrands()
    {
        return $this->brandsDao->getAllBrands();
    }

    public function getAllCategories()
    {
        return $this->categoryDao->getAllCategories();
    }

    public function showOptionBox()
    {
        echo '<div id="search-by"><form method="post">Brand: <select name="brand">';
        echo '<option value=""></option>';
        foreach (Controller::getInstance()->getAllBrands() as $brand) {
            echo "<option value='" . $brand->getBrand() . "'";
            if (isset($_POST["action"]) && $_POST["action"] == "show-by-filters" && $_POST["brand"] == $brand->getBrand()) echo "selected='selected'";
            echo ">" . $brand->getBrand() . "</option>";
        }
        echo '</select>';
        echo '&nbsp;Sort by : <select name="sort">';
        echo '<option value = "createdDESC"';
        if (isset($_POST["sort"]) && $_POST["sort"] == "createdDESC") echo 'selected="selected"';
        echo '>Newest</option><option value="costASC"';
        if (isset($_POST["sort"]) && $_POST["sort"] == "costASC") echo 'selected="selected"';
        echo '>Lowest price</option><option value = "costDESC"';
        if (isset($_POST["sort"]) && $_POST["sort"] == "costDESC") echo 'selected="selected"';
        echo '>Highest price</option><option value = "createdASC"';
        if (isset($_POST["sort"]) && $_POST["sort"] == "createdASC") echo 'selected="selected"';
        echo '>Oldest</option>';
        echo '</select><button id="show-by-filters-button" type="submit" name="action" value="show-by-filters">Show</button></form>';
        echo '</div >';
    }
}

?>