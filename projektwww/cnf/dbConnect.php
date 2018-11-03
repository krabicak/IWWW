<?php
try {
    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,
        DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("INSERT INTO newsletter (email) VALUES (:email)");
    $stmt->bindParam(':email', $_POST["email"]);
    $stmt->execute();

    $message = "You are subscribed!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>