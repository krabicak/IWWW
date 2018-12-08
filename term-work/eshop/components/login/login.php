<?php
Controller::getInstance()->login();
?>

<form id="login-form" method="post">
    <h2>Login</h2>
    <input type="email" name="login-email" title="E-mail" placeholder="Email">
    <input type="password" name="password" title="Password" placeholder="Password">
    <input type="submit" value="Log in">
</form>
