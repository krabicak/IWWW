<div id="brand-management">
    <h1>Brands</h1>
    <form id="search_by_brand" method='post'>
        <input type='text' name='brand'>
        <input type='submit' name='action' value='by-brand'>
    </form>
    <br>

    <?php
    Controller::getInstance()->brandsManagement();
    ?>
</div>