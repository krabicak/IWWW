<?php
if (Controller::getInstance()->isUserManager()) {
    require_once "components/orders-management/orders-management.php";
} else header("location: " . BASE_URL);
?>