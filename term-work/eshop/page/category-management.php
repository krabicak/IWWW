<?php
if (Controller::getInstance()->isUserManager()) {
    require_once "components/category-management/category-management.php";
} else header("location: " . BASE_URL);
?>