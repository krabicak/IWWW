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
        return self::$basket;
    }

    public static function addProduct($product)
    {
        self::$basket[self::getSize()] = $product->getId();
        $_SESSION['basket'] = self::$basket;
    }

    public static function removeProduct($product)
    {
        $newBasket = NULL;
        $deleted = false;
        foreach (self::$basket as $item) {
            if ($item != $product || $deleted) {
                $newBasket[self::size($newBasket)] = $item;
            } elseif ($item == $product) {
                $deleted = !$deleted;
            }
        }
        $_SESSION['basket'] = $newBasket;
    }

    public function removeAllProducts()
    {
        self::$basket = NULL;
        $_SESSION['basket'] = NULL;
    }

    public static function getSize()
    {
        if (self::$basket == NULL) return 0;
        return sizeof(self::$basket);
    }

    private static function size($array)
    {
        if ($array == NULL) return 0;
        return sizeof($array);
    }
}