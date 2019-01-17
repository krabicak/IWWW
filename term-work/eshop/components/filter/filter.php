<section id="filter-by">
    <form method="post">Značka:
        <select name="brand">
            <option value="">všechny</option>
            <?php
            Controller::getInstance()->showFilter();
            ?>
        </select>
        <button id="show-by-filters-button" type="submit" name="action" value="show-by-filters">Zobrazit</button>
    </form>
    <?php
    if (isset($_GET["q"])) {
        Controller::getInstance()->showResults();
    }
    ?>
</section>
