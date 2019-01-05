<?php
require_once "cnf/config.php";
function autoload($className)
{
    if (file_exists('./class/' . $className . '.php')) {
        require_once './class/' . $className . '.php';
        return true;
    }

    if (file_exists('./class/dao/' . $className . '.php')) {
        require_once './class/dao/' . $className . '.php';
        return true;
    }

    if (file_exists('./class/model/' . $className . '.php')) {
        require_once './class/model/' . $className . '.php';
        return true;
    }

    if (file_exists('./class/libs/' . $className . '.php')) {
        require_once './class/libs/' . $className . '.php';
        return true;
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
    <link rel="stylesheet" href="Trumbowyg/dist/ui/trumbowyg.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="components/header/header.css">
    <link rel="stylesheet" type="text/css" href="components/navigation/navigation.css">
    <link rel="stylesheet" type="text/css" href="components/login/login.css">
    <link rel="stylesheet" type="text/css" href="components/registration/registration.css">
    <link rel="stylesheet" type="text/css" href="components/user-management/user-management.css">
    <link rel="stylesheet" type="text/css" href="components/brand-management/brand-management.css">
    <link rel="stylesheet" type="text/css" href="components/category-management/category-management.css">
    <link rel="stylesheet" type="text/css" href="components/my-profile/my-profile.css">
    <link rel="stylesheet" type="text/css" href="components/products/products.css">
    <link rel="stylesheet" type="text/css" href="components/detail/detail.css">
    <link rel="stylesheet" type="text/css" href="components/product-management/product-management.css">
    <link rel="stylesheet" type="text/css" href="components/edit-description/edit-description.css">
</head>
<body>

<?php
include "components/header/header.php";
?>

<div id="content">
    <?php
    require_once "default/default.php";
    ?>
    <main>
        <?php
        Controller::getInstance()->navigation();
        ?>
    </main>
</div>

</body>
</html>