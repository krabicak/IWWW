<?php
Controller::getInstance()->login();
?>

<form id="login-form" method="post">
    <h2>Přihlášení</h2>
    <input type="email" name="login-email" title="E-mail" placeholder="Email">
    <input type="password" name="password" title="Password" placeholder="Heslo">
    <input type="submit" value="Přihlásit">
</form>
