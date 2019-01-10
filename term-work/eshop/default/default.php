<?php
require_once "components/navigation/nav.php";

if (isset($_GET["page"]) && ($_GET["page"] == "products" || $_GET["page"] == "search")) {
    require_once "components/filter/filter.php";
}

