<?php
if (isset($_POST["add-to-basket"])) {
    if (Controller::getInstance()->isUserLogged()) Controller::getInstance()->addProductToBasket();
    else echo "<script>$(document).ready(function(){alert('Nejprve se musíte přihlásit');});</script>";
}
if (isset($_GET["category"])) Controller::getInstance()->showProductsByCategory();
elseif (isset($_GET["q"])) Controller::getInstance()->searchProducts();
else Controller::getInstance()->showAllProducts();
?>





