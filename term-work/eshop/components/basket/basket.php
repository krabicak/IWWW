<section id="basket">
    <h1>Košík</h1>

    <div class="container">
        <div>
            <h2>Položky v košíku:</h2>
            <?php
            Controller::getInstance()->basket();
            ?>
        </div>
        <form method="post">
            <h2>Doručovací údaje</h2>
            <table>
                <tr>
                    <td>Jméno:</td>
                    <td><input type='text' name='first-name' required='required'
                               value='<?php echo Controller::getInstance()->getLoggedUserFirstName(); ?>'></td>
                </tr>
                <tr>
                    <td>Příjmení:</td>
                    <td><input type='text' name='last-name' required='required'
                               value='<?php echo Controller::getInstance()->getLoggedUserLastName(); ?>'></td>
                </tr>
                <tr>
                    <td>Adresa:</td>
                    <td><input type='text' name='address' required='required'
                               value='<?php echo Controller::getInstance()->getLoggedUserAddress(); ?>'>
                    </td>
                </tr>
                <tr>
                    <td>Další informace (nepovinné):</td>
                    <td><input type='text' name='info'></td>
                </tr>
            </table>
            <br>
            <button name='action' value='buy'
                    type='submit'<?php if (Controller::getInstance()->isBasketEmpty()) echo "disabled" ?>>Objednat
            </button>
        </form>
    </div>
</section>