<?php
namespace Core;

class Congif {
    public function init()
    {
        $configurations = require_once BASE_PATH . '\\DBConfig\\configs.php';
        define("DATABASE_HOST",$configurations['database']['host']);
        define("DATABASE_USER",$configurations['database']['user']);
        define("DATABASE_PASS",$configurations['database']['password']);
        define("DATABASE_NAME",$configurations['database']['name']);
    }
}