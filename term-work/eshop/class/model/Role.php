<?php

final class Role
{
    private static $user, $admin, $manager;
    private $name;

    private function __construct($name)
    {
        $this->name = $name;
    }

    public static function getUser()
    {
        if (!isset(self::$user)) {
            self::$user = new self('user');
        }
        return self::$user;
    }

    public static function getAdmin()
    {
        if (!isset(self::$admin)) {
            self::$admin = new self('admin');
        }
        return self::$admin;
    }

    public static function getManager()
    {
        if (!isset(self::$manager)) {
            self::$manager = new self('manager');
        }
        return self::$manager;
    }

    public function getRole()
    {
        return $this->name;
    }

    public static function getArray()
    {
        return [
            "user" => self::getUser(),
            "admin" => self::getAdmin(),
            "manager" => self::getManager()
        ];
    }
}