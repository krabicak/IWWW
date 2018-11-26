<?php
ob_start();
session_start();
require_once "cnf/config.php";
function autoload($className)
{
    if (file_exists('./class/' . $className . '.php')) {
        require_once './class/' . $className . '.php';
        return true;
    }
    return false;
}

spl_autoload_register('autoload');
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>E-shop Petr Hotovec</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="components/header/header.css">
    <link rel="stylesheet" type="text/css" href="components/navigation/navigation.css">
    <link rel="stylesheet" type="text/css" href="components/login/login.css">
    <link rel="stylesheet" type="text/css" href="components/registration/registration.css">
</head>
<body>
<?php
include "default/default.php";
?>

<div id="content">
    <?php
    include "components/navigation/nav.php";
    ?>
    <?php
    if (isset($_GET["q"])) {
        require_once "page/search-page.php";
    } else
        if (isset($_GET["page"])) {
            if (file_exists("page/" . $_GET["page"] . ".php")) {
                require_once "page/" . $_GET["page"] . ".php";
            }
        }
    ?>
</div>

</body>
</html>