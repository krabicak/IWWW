<?php
if (Controller::getInstance()->isUserLogged()) {
    require_once "components/basket/basket.php";
} else header("location: " . BASE_URL);
?>