<?php
require_once "components/navigation/nav.php";

if (isset($_GET["page"]) && $_GET["page"] == "products") {
    Controller::getInstance()->showOptionBox();
}

