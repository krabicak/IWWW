<form id="login-form" method="post">
    <h2>Login</h2>
    <input type="email" name="email" title="E-mail" placeholder="Email">
    <input type="password" name="password" title="Password" placeholder="Password">
    <input type="checkbox" id="save-password" title="Save password" name="save-password">
    <label for="save-password">Save?</label>
    <input type="submit" value="Log in">
</form>

<?php
if (isset($_POST["email"]) && $_POST["password"]) {
    if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
            DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT id,email,password,role FROM users_view WHERE email=:email");
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user && password_verify($_POST['password'], $user['password'])) {
            $_SESSION["userID"] = $user["id"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["role"] = $user["role"];
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            echo "<script>alert('User not found!')</script>";
        }
    }
}
?>
