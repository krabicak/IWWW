<?php

class Controller
{
    private $userDao;
    static private $instance = NULL;

    static function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new Controller();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->userDao = new UserDao(Connection::getPdoInstance());
    }

    public function login()
    {
        if (isset($_POST["login-email"]) && $_POST["password"]) {
            if (filter_var($_POST["login-email"], FILTER_VALIDATE_EMAIL)) {
                $auth = Authentication::getInstance();
                if ($auth->login($_POST["login-email"], $_POST["password"])) {
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    echo "<script>alert('User not found!')</script>";
                }
            }
        }
    }

    public function isUserLogged()
    {
        return isset($_SESSION["identity"]);
    }

    public function isUserAdmin()
    {
        return (isset($_SESSION["identity"]) && $_SESSION["identity"]->getRole() == "admin");
    }

    public function logout()
    {
        Authentication::getInstance()->logout();
        header("location: " . BASE_URL);
        exit();
    }

    public function navigation()
    {
        if (isset($_GET["q"])) {
            require_once "page/search-page.php";
        } else
            if (isset($_GET["page"])) {
                if (file_exists("page/" . $_GET["page"] . ".php")) {
                    require_once "page/" . $_GET["page"] . ".php";
                }
            } else {
                require_once "default/default.php";
            }
    }

    public function userManagement()
    {
        $allUserRoles = $this->userDao->getAllRoles();
        if (isset($_POST["action"])) {
            if ($_POST["action"] == "by-email") {
                echo "<h2>Users by email</h2>";
                $allUsersResult = $this->userDao->getByEmail($_POST["email"]);

                $dataTable = new UsersTable($allUsersResult, $allUserRoles);
                $dataTable->addColumn("id", "ID");
                $dataTable->addColumn("email", "Email");
                $dataTable->addColumn("created", "Created");
                $dataTable->addColumn("role", "Role");
                $dataTable->render();
            } else {
                $user = explode(':', $_POST["action"], 2);
                if ($user[0] == 'remove-user') {
                    $this->userDao->deleteUser($user[1]);
                    unset($_POST["action"]);
                    header("Refresh:0");
                } elseif ($user[0] == 'update-user') {
                    $this->userDao->updateUser($user[1], $_POST["email"], $_POST["role"]);
                    unset($_POST["action"]);
                    header("Refresh:0");
                } elseif ($user[0] == 'add-user') {
                    $this->userDao->addUser($_POST["email"], $_POST["role"]);
                    unset($_POST["action"]);
                    header("Refresh:0");
                }
            }
        } else {
            echo "<h2>All users</h2>";
            $allUsersResult = $this->userDao->getAllUsers();

            $dataTable = new UsersTable($allUsersResult, $allUserRoles);
            $dataTable->addColumn("id", "ID");
            $dataTable->addColumn("email", "Email");
            $dataTable->addColumn("created", "Created");
            $dataTable->addColumn("role", "Role");
            $dataTable->render();

        }
    }

    public function register()
    {
        if (isset($_POST["email"]) && $_POST["password"] && $_POST["password-again"]) {
            if (filter_var($_POST["login-email"], FILTER_VALIDATE_EMAIL)) {
                if ($_POST["password-again"] == $_POST["password"]) {
                    $this->userDao->addUser($_POST['email'], 'user', password_hash($_POST['password'], PASSWORD_BCRYPT));
                    echo "<script>alert('User registered!')</script>";
                } else echo "<script>alert('Passwords doesn\'t match')</script>";
            } else echo "<script>alert('Bad email')</script>";
        }
    }
}

?>