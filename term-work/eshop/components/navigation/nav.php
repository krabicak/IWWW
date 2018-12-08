<nav>
    <h2>Categories</h2>
    <a href="#uvod">dsadsad</a>
    <a href="#historie">gdsgsd</a>
    <br/>
    <?php
    if (!Controller::getInstance()->isUserLogged()) {
        require_once "components/login/login.php";
        require_once "components/registration/registration.php";
    } else {
        echo '<a href="' . BASE_URL . '?page=log-out">Log out</a>';
        if (Controller::getInstance()->isUserAdmin()) {
            echo '<a href="' . BASE_URL . '?page=user-management">Users</a>';
        }
    }
    ?>
    <br/>
</nav>