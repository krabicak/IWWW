<?php

class BrandsDao
{
    private $conn = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllBrands()
    {
        $stmt = $this->conn->prepare("SELECT brand FROM brands");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Brand');
    }

    public function getByBrand($brand)
    {
        $stmt = $this->conn->prepare("SELECT brand FROM brands WHERE brand LIKE concat('%',:brand,'%')");
        $stmt->bindParam(":brand", $brand);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Brand');
    }

    public function deleteBrand($brand)
    {
        $stmt = $this->conn->prepare("DELETE FROM brands WHERE brand=:brand");
        $stmt->bindParam(":brand", $brand);
        $stmt->execute();
    }

    public function updateBrand($id, $brand)
    {
        $stmt = $this->conn->prepare("UPDATE brands SET brand=:brand WHERE brand=:id");
        $stmt->bindParam(":brand", $brand);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    public function addBrand($brand)
    {
        $stmt = $this->conn->prepare("INSERT INTO brands(brand) VALUES (:brand)");
        $stmt->bindParam(":brand", $brand);
        $stmt->execute();
    }
}