<nav>
    <h2>Kategorie</h2>
    <?php
    Controller::getInstance()->categories();
    ?>
    <br/>
    <?php
    if (!Controller::getInstance()->isUserLogged()) {
        require_once "components/login/login.php";
        require_once "components/registration/registration.php";
    } else {
        echo '<a href="' . BASE_URL . '?page=my-orders">Moje objednávky</a>';
        if (Controller::getInstance()->isUserManager()) {
            echo "<h2>Administrace</h2>";
            echo '<a href="' . BASE_URL . '?page=orders-management">Objednávky</a>';
            echo '<a href="' . BASE_URL . '?page=product-management">Produkty</a>';
            echo '<a href="' . BASE_URL . '?page=brand-management">Značky</a>';
            echo '<a href="' . BASE_URL . '?page=category-management">Kategorie</a>';
        }
        if (Controller::getInstance()->isUserAdmin()) {
            echo "<h2>Možnosti správce</h2>";
            echo '<a href="' . BASE_URL . '?page=user-management">Uživatelé</a>';
        }
    }
    ?>
    <br/>
</nav>