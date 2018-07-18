<?php

define("BASE_PATH" , dirname(__FILE__));

spl_autoload_register(function ($class) {
    $path =   BASE_PATH . DIRECTORY_SEPARATOR ."App" . DIRECTORY_SEPARATOR . $class .DIRECTORY_SEPARATOR . "$class.php";
//    dd($path);
   require_once $path;
});


