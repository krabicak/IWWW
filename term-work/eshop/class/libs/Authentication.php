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
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if (password_verify($password, $user["password"])) {
            $stmt->execute();
            self::$identity = $stmt->fetchObject('User');
            $_SESSION["identity"] = self::$identity;
            return true;
        } else {
            return false;
        }
    }

    public function reload()
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=:id");
        $var = self::$identity->getId();
        $stmt->bindParam(':id', $var);
        $stmt->execute();
        self::$identity = $stmt->fetchObject('User');
        $_SESSION["identity"] = self::$identity;
    }

    public function isPasswordCorrect($password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=:id");
        $var = self::$identity->getId();
        $stmt->bindParam(':id', $var);
        $stmt->execute();
        $user = $stmt->fetch();
        return password_verify($password, $user["password"]);
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