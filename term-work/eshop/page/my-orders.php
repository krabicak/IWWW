<?php
if (Controller::getInstance()->isUserLogged()) {
    require_once "components/my-orders/my-orders.php";
} else header("location: " . BASE_URL);
?>