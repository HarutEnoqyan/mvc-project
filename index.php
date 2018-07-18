<?php
require_once 'App/helpers.php';
require_once 'autoload.php';

$pdh = null;

$conn = new \Core\Connection();
$config = new Core\Congif();
$route = new Core\Router();
//$migrate = new \Core\Migration();
$config->init();
$conn->init();
$route->init();
//$migrate-

//dd($pdh);




