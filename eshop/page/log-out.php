<?php
Authentication::getInstance()->logout();
header("location: " . BASE_URL);
exit();
?>