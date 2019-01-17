<?php

final class State
{
    private static $processing, $sent, $canceled;
    private $name;

    private function __construct($name)
    {
        $this->name = $name;
    }

    public static function getProcessing()
    {
        if (!isset(self::$processing)) {
            self::$processing = new self('příprava');
        }
        return self::$processing;
    }

    public static function getSent()
    {
        if (!isset(self::$sent)) {
            self::$sent = new self('odesláno');
        }
        return self::$sent;
    }

    public static function getCanceled()
    {
        if (!isset(self::$canceled)) {
            self::$canceled = new self('zrušeno');
        }
        return self::$canceled;
    }

    public function getState()
    {
        return $this->name;
    }

    public static function getArray()
    {
        return [
            "příprava" => self::getProcessing(),
            "zrušeno" => self::getCanceled(),
            "odesláno" => self::getSent()
        ];
    }
}