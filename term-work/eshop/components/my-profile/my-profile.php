<?php
Controller::getInstance()->changeUser();
?>
<section id="my-profile">
    <h1>Profil</h1>
    <div class="container">
        <form method="post">
            <h2>Základní informace</h2>
            <table>
                <tr>
                    <td>&emsp;Jméno:</td>
                    <td><input type='text' name='first-name'
                               value='<?php echo Controller::getInstance()->getLoggedUserFirstName(); ?>'></td>
                </tr>
                <tr>
                    <td>&emsp;Příjmení:</td>
                    <td><input type='text' name='last-name'
                               value='<?php echo Controller::getInstance()->getLoggedUserLastName(); ?>'></td>
                </tr>
                <tr>
                    <td>&emsp;Email:</td>
                    <td><input type='text' name='email'
                               value='<?php echo Controller::getInstance()->getLoggedUserEmail(); ?>'></td>
                </tr>
                <tr>
                    <td>&emsp;Adresa:</td>
                    <td><input type='text' name='address'
                               value='<?php echo Controller::getInstance()->getLoggedUserAddress(); ?>'></td>
                </tr>
            </table>
            <br>
            <button type='submit' name='action' value='save'>Uložit</button>
        </form>
        &emsp;
        <form method="post">
            <h2>Změna hesla</h2>
            <table>
                <tr>
                    <td>&emsp;Aktuální heslo:</td>
                    <td><input type='password' name='actual-password' value=''></td>
                </tr>
                <tr>
                    <td>&emsp;Nové heslo:</td>
                    <td><input type='password' name='new-password' value=''></td>
                </tr>
                <td>&emsp;Nové heslo znovu:</td>
                <td><input type='password' name='new-password-again' value=''></td>
                </tr>
            </table>
            <br>
            <button type='submit' name='action' value='change'>Změnit heslo</button>
        </form>
    </div>
</section>
