<div id="user-management">
    <h1>Uživatelé</h1>
    <form id="search_by_email" method='post'>
        <input type='email' name='email'>
        <button type='submit' name='action' value='by-email'>Vyhledat</button>
    </form>
    <br>

    <?php
    Controller::getInstance()->userManagement();
    ?>
</div>
