<header>
    <form method="get">
        <nav id="nav">
            <h1 id="name-of-web" onclick="document.location.href ='<?= BASE_URL ?>';return false;">
                E-shop</h1>
            <div id="search-box">
                <input type="search"
                       id="search"
                       name="q"
                       placeholder="Hledat produkty..."
                       aria-label="Search through site products"
                    <?php if (isset($_GET["q"])) echo 'value="' . $_GET["q"] . '"' ?>
                >
                <button name='page' value='products' type='submit'>Vyhledat</button>
            </div>
            <?php
            if (Controller::getInstance()->isUserLogged()) {
                echo '<a href="' . BASE_URL . '?page=basket">Košík</a>';
                echo '<a href="' . BASE_URL . '?page=my-profile">' . Controller::getInstance()->getLoggedUserName() . '</a>';
                echo '<a href="' . BASE_URL . '?page=log-out">Odhlásit</a>';
            }
            ?>
        </nav>
    </form>
</header>