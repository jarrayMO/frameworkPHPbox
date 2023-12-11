<?php

namespace App\Config;

class ConfigReader
{
    public static function getConfig($key)
    {
        
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        return $_ENV[$key] ?? null;
    }
}