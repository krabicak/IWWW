<?php
if (Controller::getInstance()->isUserManager()) {
    require_once "components/user-management/user-management.php";
} else header("location: " . BASE_URL);
?>