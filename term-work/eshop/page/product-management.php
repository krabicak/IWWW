<?php
if (Controller::getInstance()->isUserManager()) {
    require_once "components/product-management/product-management.php";
} else header("location: " . BASE_URL);
?>