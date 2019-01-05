<?php
if (isset($_GET["category"])) {
    Controller::getInstance()->showProductsByCategory();
} else Controller::getInstance()->showAllProducts();
?>





