<?php
if (Controller::getInstance()->isUserManager()) {
    require_once "components/edit-description/edit-description.php";
} else header("location: " . BASE_URL);