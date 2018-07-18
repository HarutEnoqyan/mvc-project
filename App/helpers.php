<?php

 function dd($arg)
{
 var_dump($arg);die();
}

function view($viewName , $params = []) {

    require_once  BASE_PATH .'\\App\\Layoutes\\header.php';

    if (file_exists($viewName) {
        require_once BASE_PATH . '\\App\\Views\\'.$viewName.'.php'
    });

    require_once  BASE_PATH .'\\App\\Layoutes\\footer.php';
}