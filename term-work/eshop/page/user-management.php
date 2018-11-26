
<?php
echo "<h1>Users</h1>";
echo "<form method='get'>
        <input type='email' name='email'>
        <input type='submit' name='action' value='by-email'>
      </form>";
if ($_GET["action"]=="read-all"){
    echo "<h2>All users</h2>";
    $userDao = new UserDao(Connection::getPdoInstance());
       $allUsersResult = $userDao->getAllUsers();

    $dataTable = new DataTable($allUsersResult);
    $dataTable->addColumn("id","ID");
    $dataTable->addColumn("email","Email");
    $dataTable->addColumn("created","Created");
    $dataTable->addColumn("role","Role");
    $dataTable->render();

}else if($_GET["action"]=="by-email"){
    echo "<h2>Users by email</h2>";
    $userDao = new UserDao(Connection::getPdoInstance());
    $allUsersResult = $userDao->getByEmail($_GET["email"]);

    $dataTable = new DataTable($allUsersResult);
    $dataTable->addColumn("id","ID");
    $dataTable->addColumn("email","Email");
    $dataTable->addColumn("created","Created");
    $dataTable->addColumn("role","Role");
    $dataTable->render();
}

?>