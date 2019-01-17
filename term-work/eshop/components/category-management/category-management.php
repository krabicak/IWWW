<section id="category-management">
    <h1>Kategorie</h1>
    <form id="search_by_category" method='post'>
        <input type='text' name='category'>
        <button type='submit' name='action' value='by-category'>Vyhledat</button>
    </form>
    <br>

    <?php
    Controller::getInstance()->categoryManagement();
    ?>
</section>
