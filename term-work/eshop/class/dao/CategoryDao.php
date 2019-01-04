<?php

class CategoryDao
{
    private $conn = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllCategories()
    {
        $stmt = $this->conn->prepare("SELECT category FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Category');
    }

    public function getByCategories($name)
    {
        $stmt = $this->conn->prepare("SELECT category FROM categories WHERE category LIKE concat('%',:category,'%')");
        $stmt->bindParam(":category", $name);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Category');
    }

    public function deleteCategory($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE category=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    public function updateCategory($id, $name)
    {
        $stmt = $this->conn->prepare("UPDATE categories SET category=:category WHERE category=:id");
        $stmt->bindParam(":category", $name);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    public function addCategory($name)
    {
        $stmt = $this->conn->prepare("INSERT INTO categories(category) VALUES (:category)");
        $stmt->bindParam(":category", $name);
        $stmt->execute();
    }
}