<?php
require_once 'App/helpers.php';
require_once 'autoload.php';

$route = new Core\Router();
$config = new Core\Congif();
$conn = new \Core\Connection();
$config->init();
$route->init();
$conn->init();
