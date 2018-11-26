<?php

class UserDao
{
    private $conn = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllUsers()
    {
        $stmt = $this->conn->prepare("SELECT id,email,role,created FROM users_view");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByEmail($mail)
    {
        $stmt = $this->conn->prepare("SELECT id,email,role,created FROM users_view WHERE email LIKE concat('%',:email,'%')");
        $stmt->bindParam(':email', $mail);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>