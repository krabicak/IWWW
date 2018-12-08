<?php
require_once "cnf/config.php";
function autoload($className)
{
    if (file_exists('./class/' . $className . '.php')) {
        require_once './class/' . $className . '.php';
        return true;
    }

    if (file_exists('./controller/Controller.php')) {
        require_once './controller/Controller.php';
    }
}
spl_autoload_register('autoload');
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-shop Petr Hotovec</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="components/header/header.css">
    <link rel="stylesheet" type="text/css" href="components/navigation/navigation.css">
    <link rel="stylesheet" type="text/css" href="components/login/login.css">
    <link rel="stylesheet" type="text/css" href="components/registration/registration.css">
    <link rel="stylesheet" type="text/css" href="components/user-management/user-management.css">

</head>
<body>
<?php
include "components/header/header.php";
?>

<div id="content">
    <?php
    Controller::getInstance()->navigation();
    ?>
</div>

</body>
</html>