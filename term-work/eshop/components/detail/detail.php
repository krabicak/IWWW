<?php
Controller::getInstance()::setProduct(Controller::getInstance()->getProduct($_GET["product"]));
if (isset($_POST["add-to-basket"])) {
    if (Controller::getInstance()->isUserLogged()) Controller::getInstance()->addProductToBasket();
    else echo "<script>$(document).ready(function(){
        alert('Please login or register');
    });</script>";

}
?>
<section id="detail">
    <div id="box">
        <div>
            <h2><?php echo Controller::getInstance()::$product->getName(); ?></h2>
            <img src="<?php echo Controller::getInstance()::$product->getImage(); ?>"
                 alt="">
        </div>
        <div class="right">
            <h3>Skladem: <?php echo Controller::getInstance()::$product->getStock(); ?> Ks</h3>
            <h3>Cena: <?php echo Controller::getInstance()::$product->getCost(); ?> Kč</h3>
            <form method="post">
                <button type="submit" name="add-to-basket"
                        value="<?php echo Controller::getInstance()::$product->getId(); ?>"
                    <?php if (Controller::getInstance()::$product->getDisabled() == 1) echo "disabled"; ?>>
                    Přidat do košíku
                </button>
            </form>
        </div>
    </div>
    <div id="description">
        <h2>Popis produktu:</h2>
        <?php echo Controller::getInstance()::$product->getDescription(); ?>
    </div>
</section>
