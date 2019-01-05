<?php
if (Controller::getInstance()->isUserAdmin()) {
    require_once "components/user-management/user-management.php";
} else header("location: " . BASE_URL);
?>