<div id="category-management">
    <h1>Categories</h1>
    <form id="search_by_category" method='post'>
        <input type='text' name='category'>
        <input type='submit' name='action' value='by-category'>
    </form>

    <?php
    Controller::getInstance()->categoryManagement();
    ?>
</div>
