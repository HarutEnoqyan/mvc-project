<?php

namespace App\Models;
use Core\ORM;
use Core\Auth;

class message extends ORM
{
    public function __construct()
    {
        $this->table = 'messages';
    }

}