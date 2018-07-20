<?php
namespace App\Models;
use Core\ORM;

class Post extends ORM {
    public function __construct()
    {
        $this->table = 'posts';
    }
}