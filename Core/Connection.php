<?php

namespace Core;

use PDO;

class Connection
{
    public function init()
    {
        global $pdh;
        try {
            $pdh = new PDO('mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME, DATABASE_USER, DATABASE_PASS);
        } catch (PDOException $e) {
            show_error($e->getMessage());
        }
    }
}