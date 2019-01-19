<section id="orders-management">
    <h1>Objednávky</h1>
    <form id="search_by_id" method='post'>
        <input type='text' name='id'>
        <button type='submit' name='action' value='by-id'>Vyhledat dle id</button>
    </form>
    <br>
    <form id="search_by_id" method='post'>
        <input type='text' name='email'>
        <button type='submit' name='action' value='by-email'>Vyhledat dle emailu</button>
    </form>
    <br>
    <div class="container">
        <?php
        Controller::getInstance()->ordersManagement();
        ?>
    </div>
</section>