<?php

class OrdersDao
{
    private $conn = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addOrder($info, $address, $state, $user, $products, $cost)
    {
        $stmt = $this->conn->prepare("INSERT INTO orders(info,address,state,users_id,cost) VALUES (:info,:address,:state,:users_id,:cost)");
        $stmt->bindParam(":info", $info);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":state", $state);
        $stmt->bindParam(":users_id", $user);
        $stmt->bindParam(":cost", $cost);
        $stmt->execute();

        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE address=:address AND state=:state AND users_id=:users_id AND cost=:cost ORDER BY created DESC");
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":state", $state);
        $stmt->bindParam(":users_id", $user);
        $stmt->bindParam(":cost", $cost);
        $stmt->execute();
        $order = $stmt->fetchAll(PDO::FETCH_CLASS, 'Order');
        foreach ($products as $product) {
            $stmt = $this->conn->prepare("SELECT * FROM costs WHERE product=:product ORDER BY created DESC");
            $stmt->bindParam(":product", $product);
            $stmt->execute();
            $cost = $stmt->fetchAll(PDO::FETCH_CLASS, 'Cost');
            $stmt = $this->conn->prepare("INSERT INTO orders_has_products(orders_id,costs_id) VALUES (:orders_id,:costs_id)");
            $or = $order[0]->getId();
            $cos = $cost[0]->getId();
            $stmt->bindParam(":orders_id", $or);
            $stmt->bindParam(":costs_id", $cos);
            $stmt->execute();
        }
    }

    public function getAllOrders($productsDao)
    {
        $stmt = $this->conn->prepare("SELECT * FROM orders ORDER BY created DESC");
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_CLASS, 'Order');
        foreach ($orders as $order) {
            $order->setProducts($productsDao->getProductsByOrderId($order->getId()));
        }
        return $orders;
    }

    public function getAllOrdersByUser($user, $productsDao)
    {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE users_id=:users_id ORDER BY created DESC");
        $stmt->bindParam(":users_id", $user);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_CLASS, 'Order');
        foreach ($orders as $order) {
            $order->setProducts($productsDao->getProductsByOrderId($order->getId()));
        }
        return $orders;
    }

    public function getCostsIdOrder($order)
    {
        $stmt = $this->conn->prepare("SELECT costs_id FROM orders_has_products WHERE orders_id=:orders_id");
        $stmt->bindParam(":orders_id", $order);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cancelOrder($order)
    {
        $stmt = $this->conn->prepare("UPDATE orders SET state=:state WHERE id=:id");
        $state = State::getCanceled()->getState();
        $stmt->bindParam(":id", $order);
        $stmt->bindParam(":state", $state);
        $stmt->execute();
    }

    public function sendOrder($order)
    {
        $stmt = $this->conn->prepare("SELECT products.id, products.stock 
          FROM products JOIN costs ON products.id = costs.product 
          JOIN orders_has_products ON costs.id = orders_has_products.costs_id 
          WHERE orders_has_products.orders_id=:id");
        $stmt->bindParam(":id", $order);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
        foreach ($products as $product) {
            $stmt = $this->conn->prepare("UPDATE products SET stock=:stock WHERE id=:id");
            $id = $product->getId();
            $stock = $product->getStock() - 1;
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":stock", $stock);
            $stmt->execute();
        }

        $stmt = $this->conn->prepare("UPDATE orders SET state=:state WHERE id=:id");
        $state = State::getSent()->getState();
        $stmt->bindParam(":id", $order);
        $stmt->bindParam(":state", $state);
        $stmt->execute();
    }

    public function getById($productsDao, $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id LIKE concat('%',:id,'%') ORDER BY created DESC ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_CLASS, 'Order');

        foreach ($orders as $order) {
            $order->setProducts($productsDao->getProductsByOrderId($order->getId()));
        }

        return $orders;
    }
}