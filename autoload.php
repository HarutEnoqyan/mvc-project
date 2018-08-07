<?php

define("BASE_PATH" , dirname(__FILE__));
include "vendor/autoload.php";

spl_autoload_register(function ($class) {

    $path =   BASE_PATH . DIRECTORY_SEPARATOR  . "$class.php";
//    dd($path);
   require_once $path;


});


