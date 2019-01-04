<?php
if (Controller::getInstance()->isUserLogged()) {
    require_once "components/my-profile/my-profile.php";
} else header("location: " . BASE_URL);
?>