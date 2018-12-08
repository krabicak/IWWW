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
        $stmt = $this->conn->prepare("SELECT id,email,role,created FROM users");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllRoles()
    {
        $stmt = $this->conn->prepare("SELECT role FROM role");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByEmail($mail)
    {
        $stmt = $this->conn->prepare("SELECT id,email,role,created FROM users WHERE email LIKE concat('%',:email,'%')");
        $stmt->bindParam(':email', $mail);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function deleteUser($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function updateUser($id, $email, $role)
    {
        $stmt = $this->conn->prepare("UPDATE users SET email=:email,role=:role WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
    }

    public function addUser($email, $role, $password)
    {
        $stmt = $this->conn->prepare("INSERT INTO users (email, role, password) VALUES (:email,:role,:password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
    }
}

?>