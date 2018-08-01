<?php
namespace Core;

class Config {
    public static function init()
    {
        $configurations = require_once BASE_PATH . DIRECTORY_SEPARATOR.'DBConfig'.DIRECTORY_SEPARATOR.'configs.php';
        define("DATABASE_HOST",$configurations['database']['host']);
        define("DATABASE_USER",$configurations['database']['user']);
        define("DATABASE_PASS",$configurations['database']['password']);
        define("DATABASE_NAME",$configurations['database']['name']);
    }
}