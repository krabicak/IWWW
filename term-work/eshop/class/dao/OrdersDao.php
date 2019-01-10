<?php

class OrdersDao
{
    private $conn = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
}