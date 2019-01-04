<?php
Controller::getInstance()->changeUser();
?>
<div id="my-profile">
    <h1>My info</h1>
    <form method="post">
        <h2>Basic info</h2>
        <table>
            <?php
            echo "<tr>";
            echo "<td>First name:</td>";
            echo "<td><input type='text' name='first-name' value='" . Controller::getInstance()->getLoggedUserFirstName() . "'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Last name:</td>";
            echo "<td><input type='text' name='last-name' value='" . Controller::getInstance()->getLoggedUserLastName() . "'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Email:</td>";
            echo "<td><input type='text' name='email' value='" . Controller::getInstance()->getLoggedUserEmail() . "'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>Address:</td>";
            echo "<td><input type='text' name='address' value='" . Controller::getInstance()->getLoggedUserAddress() . "'></td>";
            echo "</tr>";
            ?>
        </table>
        <br>
        <input type='submit' name='action' value='save'>
    </form>
    <form method="post">
        <h2>Password change</h2>
        <table>
            <?php
            echo "<tr>";
            echo "<td>Actual password:</td>";
            echo "<td><input type='password' name='actual-password' value=''></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>New password:</td>";
            echo "<td><input type='password' name='new-password' value=''></td>";
            echo "</tr>";
            echo "<td>New password again:</td>";
            echo "<td><input type='password' name='new-password-again' value=''></td>";
            echo "</tr>";
            ?>
        </table>
        <br>
        <input type='submit' name='action' value='change'>
    </form>
</div>
