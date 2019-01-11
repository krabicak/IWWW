<nav>
    <h2>Categories</h2>
    <?php
    Controller::getInstance()->categories();
    ?>
    <br/>
    <?php
    if (!Controller::getInstance()->isUserLogged()) {
        require_once "components/login/login.php";
        require_once "components/registration/registration.php";
    } else {
        echo '<a href="' . BASE_URL . '?page=my-orders">My orders</a>';
        if (Controller::getInstance()->isUserManager()) {
            echo "<h2>Management</h2>";
            echo '<a href="' . BASE_URL . '?page=orders-management">Orders</a>';
            echo '<a href="' . BASE_URL . '?page=product-management">Products</a>';
            echo '<a href="' . BASE_URL . '?page=brand-management">Brands</a>';
            echo '<a href="' . BASE_URL . '?page=category-management">Categories</a>';
        }
        if (Controller::getInstance()->isUserAdmin()) {
            echo "<h2>Admin management</h2>";
            echo '<a href="' . BASE_URL . '?page=user-management">Users</a>';
        }
    }
    ?>
    <br/>
</nav>