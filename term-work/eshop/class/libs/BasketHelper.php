<?php

class BasketHelper
{
    static private $instance = NULL;
    static private $basket = NULL;

    /**
     * @param null $instance
     */
    public static function setInstance($instance)
    {
        self::$instance = $instance;
    }

    static function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new BasketHelper();
        }

        return self::$instance;
    }

    private function __construct()
    {
        if (isset($_SESSION['basket'])) {
            self::$basket = $_SESSION['basket'];
        }
    }

    public static function getProducts()
    {
        return static::$basket;
    }

    public static function addProduct($product)
    {
        static::$basket[self::getSize()] = $product;
        $_SESSION['basket'] = static::$basket;
    }

    public static function getSize()
    {
        if (static::$basket == NULL) return 0;
        return sizeof(static::$basket);
    }
}