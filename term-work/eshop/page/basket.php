<?php
if (Controller::getInstance()->isUserLogged()) {
}else header("location: " . BASE_URL);
?>