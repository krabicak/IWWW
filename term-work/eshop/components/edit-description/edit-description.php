<div id="edit-description">
    <?php
    Controller::getInstance()->editDescription();
    ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
    <script src="Trumbowyg/dist/trumbowyg.min.js"></script>
    <form method="post">
        <button type="submit" name="action" value="save-description">Save</button>
        <div id="editor">
            <?php
            echo Controller::getInstance()->getDescriptionOfProduct($_GET["product"]);
            ?>
        </div>
    </form>
    <script>
        $('#editor').trumbowyg();

    </script>
</div>