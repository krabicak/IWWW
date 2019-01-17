<section id="basket">
    <h1>Basket</h1>

    <div class="container">
        <div>
            <h2>Items in basket</h2>
            <?php
            Controller::getInstance()->basket();
            ?>
        </div>
        <form method="post">
            <h2>Delivery information</h2>
            <table>
                <tr>
                    <td>First name:</td>
                    <td><input type='text' name='first-name' required='required'
                               value='<?php echo Controller::getInstance()->getLoggedUserFirstName(); ?>'></td>
                </tr>
                <tr>
                    <td>Last name:</td>
                    <td><input type='text' name='last-name' required='required'
                               value='<?php echo Controller::getInstance()->getLoggedUserLastName(); ?>'></td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td><input type='text' name='address' required='required'
                               value='<?php echo Controller::getInstance()->getLoggedUserAddress(); ?>'>
                    </td>
                </tr>
                <tr>
                    <td>Info:</td>
                    <td><input type='text' name='info'></td>
                </tr>
            </table>
            <br>
            <button name='action' value='buy'
                    type='submit'<?php if (Controller::getInstance()->isBasketEmpty()) echo "disabled" ?>>Buy
            </button>
        </form>
    </div>
</section>