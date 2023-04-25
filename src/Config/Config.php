<?php

namespace App\Config;

class Config
{
    private static $config;

    public static function load(string $configFileName)
    {
        static::$config = include_once $configFileName;
    }

    public static function get($key, $default = null): mixed
    {
        return static::$config[$key] ?? $default;
    }
}
