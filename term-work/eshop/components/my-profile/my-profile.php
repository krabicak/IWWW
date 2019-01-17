<?php
Controller::getInstance()->changeUser();
?>
<section id="my-profile">
    <h1>My info</h1>
    <div class="container">
        <form method="post">
            <h2>Basic info</h2>
            <table>
                <tr>
                    <td>&emsp;First name:</td>
                    <td><input type='text' name='first-name'
                               value='<?php echo Controller::getInstance()->getLoggedUserFirstName(); ?>'></td>
                </tr>
                <tr>
                    <td>&emsp;Last name:</td>
                    <td><input type='text' name='last - name'
                               value='<?php echo Controller::getInstance()->getLoggedUserLastName(); ?>'></td>
                </tr>
                <tr>
                    <td>&emsp;Email:</td>
                    <td><input type='text' name='email'
                               value='<?php echo Controller::getInstance()->getLoggedUserEmail(); ?>'></td>
                </tr>
                <tr>
                    <td>&emsp;Address:</td>
                    <td><input type='text' name='address'
                               value='<?php echo Controller::getInstance()->getLoggedUserAddress(); ?>'></td>
                </tr>
            </table>
            <br>
            <input type='submit' name='action' value='save'>
        </form>
        &emsp;
        <form method="post">
            <h2>Password change</h2>
            <table>
                <tr>
                    <td>&emsp;Actual password:</td>
                    <td><input type='password' name='actual - password' value=''></td>
                </tr>
                <tr>
                    <td>&emsp;New password:</td>
                    <td><input type='password' name='new-password' value=''></td>
                </tr>
                <td>&emsp;New password again:</td>
                <td><input type='password' name='new-password - again' value=''></td>
                </tr>
            </table>
            <br>
            <input type='submit' name='action' value='change'>
        </form>
    </div>
</section>
