<header>
    <form method="get">
        <nav id="nav">
            <h1 id="name-of-web" onclick="window.location.href =<?= BASE_URL ?>">E-shop</h1>
            <div id="search-box">
                <input type="search"
                       id="search"
                       name="q"
                       placeholder="Search product..."
                       aria-label="Search through site products">
                <input type="submit" value="Search!">
            </div>
            <a href=<?= BASE_URL . "?page=contact" ?>>Contact</a>
            <?php
            if (Controller::getInstance()->isUserLogged()) {
                echo '<a href="' . BASE_URL . '?page=log-out">Log out</a>';
            }
            ?>
            <a href=<?= BASE_URL . "?page=basket" ?>>Basket</a>
        </nav>
    </form>
</header>