<?php

class ProductsDao
{
    private $conn = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllProducts()
    {
        $stmt = $this->conn->prepare("SELECT * FROM products");
        $stmt->execute();
        $array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
        foreach ($array as $product) {
            $product->setCosts($this->getCostsOfProduct($product->getId()));
        }
        return $array;
    }

    public function getProductsByCategory($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE category=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
        foreach ($array as $product) {
            $product->setCosts($this->getCostsOfProduct($product->getId()));
        }
        return $array;
    }

    private function getCostsOfProduct($product)
    {
        $stmt = $this->conn->prepare("SELECT created,cost FROM costs WHERE product=:product ORDER BY created DESC");
        $stmt->bindParam(":product", $product);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Cost');
    }
}

?>