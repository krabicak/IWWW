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
        $stmt = $this->conn->prepare("SELECT id,email,role,created,first_name,last_name,address,disabled FROM users ORDER BY created DESC ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'User');
    }

    public function getByEmail($mail)
    {
        $stmt = $this->conn->prepare("SELECT id,email,role,created,first_name,last_name,address,disabled FROM users WHERE email LIKE concat('%',:email,'%') ORDER BY created DESC ");
        $stmt->bindParam(':email', $mail);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'User');
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT id,email,role,created,first_name,last_name,address,disabled FROM users WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return ($stmt->fetchAll(PDO::FETCH_CLASS, 'User'))[0];
    }

    public function deleteUser($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function updateUser($id, $email, $role, $firstName, $lastName, $address, $disabled)
    {
        $stmt = $this->conn->prepare("UPDATE users SET email=:email,role=:role,first_name=:firstName,last_name=:lastName,address=:address,disabled=:disabled WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':disabled', $disabled);
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

    public function changePassword($id, $password)
    {
        $stmt = $this->conn->prepare("UPDATE users SET password=:password WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
    }
}

?>