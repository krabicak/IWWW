<nav>
    <h2>Categories</h2>
    <a href="#uvod">dsadsad</a>
    <a href="#historie">gdsgsd</a>
    <br/>
    <?php
    if (!isset($_SESSION["userID"])) {
        require_once "components/login/login.php";
    } else {
        echo '<a href="'.BASE_URL.'?page=log-out">Log out</a>';
        if ($_SESSION["role"]=="admin"){
            echo '<a href="?page=user-management&action=read-all">Users</a>';
        }
    }
    ?>
    <br/>
</nav>