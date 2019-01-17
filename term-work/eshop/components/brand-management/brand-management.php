<section id="brand-management">
    <h1>Značky</h1>
    <form id="search_by_brand" method='post'>
        <input type='text' name='brand'>
        <button type="submit" name="action" value="by-brand">Vyhledat</button>
    </form>
    <br>

    <?php
    Controller::getInstance()->brandsManagement();
    ?>
</section>