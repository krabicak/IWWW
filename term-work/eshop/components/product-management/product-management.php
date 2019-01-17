<div id="product-management">
    <h1>Produkty</h1>
    <form id="search_by_name" method='post'>
        <input type='text' name='name'>
        <button type='submit' name='action' value='by-name'>Vyhledat dle názvu</button>
    </form>
    <br>
    <form id="search_by_id" method='post'>
        <input type='text' name='id'>
        <button type='submit' name='action' value='by-id'>Vyhledat dle id</button>
    </form>
    <br>
    <form method="post" enctype="multipart/form-data">
        Nahrávání obrázku:
        <input type="file" name="file" id="fileToUpload">
        <button type="submit" name="action" value="upload-image">Nahrát</button>
    </form>

    <?php
    Controller::getInstance()->productsManagement();
    ?>
</div>