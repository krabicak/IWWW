<?php

class Authentication
{
    private $conn = null;
    static private $instance = NULL;
    static private $identity = NULL;

    static function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new Authentication();
        }

        return self::$instance;
    }

    private function __construct()
    {
        if (isset($_SESSION['identity'])) {
            self::$identity = $_SESSION['identity'];
        }
        $this->conn = Connection::getPdoInstance();
    }

    public function login($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT id,email,password,role FROM users_view WHERE email=:email");
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user && password_verify($email, $password)) {
            self::$identity = new Identity($user["id"], $user["email"], $user["role"]);
            return true;
        } else {
            return false;
        }
    }

    public function hashIdentity()
    {

    }

    public static function getIdentity()
    {
        return self::$identity;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }
}

?>