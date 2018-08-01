<?php

namespace Core;

use PDO;

class Connection
{
    public static function init()
    {
        global $pdh;
        try {
            $pdh = new PDO('mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME, DATABASE_USER, DATABASE_PASS);
//            dd($pdh);
//            echo "connection success";
        } catch (\PDOException $e) {
          dd($e->getMessage());
        }
    }
}