<?php
if (Controller::getInstance()->isUserManager()) {
    require_once "components/brand-management/brand-management.php";
} else header("location: " . BASE_URL);
?>