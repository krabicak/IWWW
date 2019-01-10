<div id="filter-by">
    <form method="post">Brand:
        <select name="brand">
            <option value="">all</option>
            <?php
            Controller::getInstance()->showFilter();
            ?>
        </select>
        <button id="show-by-filters-button" type="submit" name="action" value="show-by-filters">Show</button>
    </form>
    <?php
    if (isset($_GET["q"])) {
        Controller::getInstance()->showResults();
    }
    ?>
</div>
