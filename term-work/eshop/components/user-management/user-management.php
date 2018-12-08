<div id="user-management">
    <h1>Users</h1>
    <form id="search_by_email" method='post'>
        <input type='email' name='email'>
        <input type='submit' name='action' value='by-email'>
    </form>

    <?php
    Controller::getInstance()->userManagement();
    ?>
</div>
