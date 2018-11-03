<?php
include "cnf/config.php";
include "cnf/dbConnect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>

<?php
include "page/default/default.php";
if (isset($_GET["page"])) {
    if (file_exists("./page/" . $_GET["page"] . ".php"))
        include "./page/" . $_GET["page"] . ".php";
} else if (file_exists("./page/home.php"))
    include "./page/home.php";

include "page/default/footer.php";
?>

</body>
</html>