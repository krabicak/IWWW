<div id="product-management">
    <h1>Products</h1>
    <form id="search_by_name" method='post'>
        <input type='text' name='name'>
        <input type='submit' name='action' value='by-name'>
    </form>
    <br>
    <form id="search_by_id" method='post'>
        <input type='text' name='id'>
        <input type='submit' name='action' value='by-id'>
    </form>
    <br>
    <form method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="file" id="fileToUpload">
        <button type="submit" name="action" value="upload-image">Upload</button>
    </form>

    <?php
    Controller::getInstance()->productsManagement();
    ?>
</div>