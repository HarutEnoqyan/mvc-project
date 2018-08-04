<?php
namespace App\Models;
use Core\ORM;

class Friend extends ORM {
    public function __construct()
    {
        $this->table = 'friends';
    }
}