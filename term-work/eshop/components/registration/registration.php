<?php
Controller::getInstance()->register();
?>
<form id="registration-form" method="post">
    <h2>Registrace</h2>
    <input type="email" name="email" title="E-mail" placeholder="Email">
    <input type="password" name="password" title="Password" placeholder="Heslo">
    <input type="password" name="password-again" title="Password again" placeholder="Heslo znovu">
    <input type="submit" value="Registrovat">
</form>