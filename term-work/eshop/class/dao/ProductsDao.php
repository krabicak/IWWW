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
        $stmt = $this->conn->prepare("SELECT * FROM products ORDER BY created DESC");
        $stmt->execute();
        $array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
        foreach ($array as $product) {
            $product->setCosts($this->getCostsOfProduct($product->getId()));
        }
        return $array;
    }

    public function getProductsByCategory($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE category=:id ORDER BY created DESC");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
        foreach ($array as $product) {
            $product->setCosts($this->getCostsOfProduct($product->getId()));
        }
        return $array;
    }

    public function getProductsByCategoryAndBrand($id, $brand)
    {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE category=:id AND brand=:brand ORDER BY created DESC");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":brand", $brand);
        $stmt->execute();
        $array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
        foreach ($array as $product) {
            $product->setCosts($this->getCostsOfProduct($product->getId()));
        }
        return $array;
    }

    public function getProductsByBrand($brand)
    {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE brand=:brand ORDER BY created DESC");
        $stmt->bindParam(":brand", $brand);
        $stmt->execute();
        $array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
        foreach ($array as $product) {
            $product->setCosts($this->getCostsOfProduct($product->getId()));
        }
        return $array;
    }

    public function getProductById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id=:id ORDER BY created DESC");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
        foreach ($array as $product) {
            $product->setCosts($this->getCostsOfProduct($product->getId()));
        }
        return $array;
    }

    public function getProductsByOrderId($id)
    {
        $stmt = $this->conn->prepare("SELECT 
            products.id,
            products.created,
            products.name,
            products.description,
            products.image,
            products.stock,
            products.brand,
            products.category
            FROM products 
          JOIN costs on products.id = costs.product 
          JOIN orders_has_products on costs.id = orders_has_products.costs_id 
          WHERE orders_has_products.orders_id=:id ORDER BY products.created DESC");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
        foreach ($array as $product) {
            $product->setCosts($this->getCostsOfProduct($product->getId()));
        }
        return $array;
    }

    public function getProductsByName($name)
    {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE name LIKE concat('%',:name,'%') ORDER BY created DESC");
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        $array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
        foreach ($array as $product) {
            $product->setCosts($this->getCostsOfProduct($product->getId()));
        }
        return $array;
    }

    private function getCostsOfProduct($product)
    {
        $stmt = $this->conn->prepare("SELECT * FROM costs WHERE product=:product ORDER BY created DESC");
        $stmt->bindParam(":product", $product);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Cost');
    }

    public function updateDescriptionOfProduct($id, $description)
    {
        $stmt = $this->conn->prepare("UPDATE products SET description=:description WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
    }

    public function addCost($cost, $product)
    {
        $stmt = $this->conn->prepare("INSERT INTO costs(cost, product) VALUES (:cost,:product)");
        $stmt->bindParam(":cost", $cost);
        $stmt->bindParam(":product", $product);
        $stmt->execute();
    }

    public function addProduct($name, $image, $stock, $brand, $category, $cost)
    {
        $stmt = $this->conn->prepare("INSERT INTO products(name, image, stock, brand, category) VALUES (:name,:image,:stock,:brand,:category)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":image", $image);
        $stmt->bindParam(":stock", $stock);
        $stmt->bindParam(":brand", $brand);
        $stmt->bindParam(":category", $category);
        $stmt->execute();

        $stmt = $this->conn->prepare("SELECT * FROM products WHERE name =:name 
          AND image=:image AND stock=:stock AND brand=:brand AND category=:category
          ORDER BY created DESC");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":image", $image);
        $stmt->bindParam(":stock", $stock);
        $stmt->bindParam(":brand", $brand);
        $stmt->bindParam(":category", $category);
        $stmt->execute();
        $array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
        foreach ($array as $product) {
            $product->setCosts($this->getCostsOfProduct($product->getId()));
        }

        $this->addCost($cost, $array[0]->getId());
    }

    public function updateProduct($id, $name, $image, $stock, $brand, $category, $cost, $disabled)
    {
        $stmt = $this->conn->prepare("UPDATE products SET name=:name,image=:image, stock=:stock,brand=:brand,category=:category,disabled=:disabled WHERE id=:id");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":image", $image);
        $stmt->bindParam(":stock", $stock);
        $stmt->bindParam(":brand", $brand);
        $stmt->bindParam(":category", $category);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":disabled", $disabled);
        $stmt->execute();

        $oldCost = $this->getCostsOfProduct($id)[0];
        if (isset($oldCost)) {
            if ($oldCost->getCost() != $cost) {
                $this->addCost($cost, $id);
            }
        }
    }

    public function searchProducts($keyword)
    {
        $stmt = $this->conn->prepare("
          SELECT * 
              FROM products JOIN categories on products.category = categories.category
              WHERE 
                  products.disabled = 0 AND
                  categories.disabled = 0 AND (
                  products.name LIKE concat('%',:keyword,'%') OR 
                  products.description LIKE concat('%',:keyword,'%') OR 
                  products.brand LIKE concat('%',:keyword,'%') OR
                  products.category LIKE concat('%',:keyword,'%'))
              ORDER BY created DESC");
        $stmt->bindParam(":keyword", $keyword);
        $stmt->execute();
        $array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
        foreach ($array as $product) {
            $product->setCosts($this->getCostsOfProduct($product->getId()));
        }
        return $array;
    }

    public function searchProductsWithBrand($keyword, $brand)
    {
        $stmt = $this->conn->prepare("
          SELECT * 
              FROM products JOIN categories on products.category = categories.category
              WHERE 
                  products.disabled = 0 AND
                  categories.disabled = 0 AND 
                  products.brand=:brand AND (
                  products.name LIKE concat('%',:keyword,'%') OR 
                  products.description LIKE concat('%',:keyword,'%') OR 
                  products.category LIKE concat('%',:keyword,'%')
                  )
              ORDER BY created DESC");
        $stmt->bindParam(":keyword", $keyword);
        $stmt->bindParam(":brand", $brand);
        $stmt->execute();
        $array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
        foreach ($array as $product) {
            $product->setCosts($this->getCostsOfProduct($product->getId()));
        }
        return $array;
    }
}

?>