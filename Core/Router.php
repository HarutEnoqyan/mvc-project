<?php

namespace Core;

class Router {
    public function init()
    {
        $route = 'main/index';
        if (!empty($_GET['route'])) {
            $route = $_GET['route'];
        }
        $controllerAction = explode('/', $route);
        if (count($controllerAction) === 2) {
            $controller = ucfirst($controllerAction[0]);
            $action = ucfirst($controllerAction[1]);

            $className = "\\App\\Controllers\\{$controller}Controller";
            $c = new $className();
            $methodName = "action{$action}";
            if (!method_exists($c, $methodName)) {
                echo "Unknown controller action $methodName"; die();
            }
            $c->$methodName();
        } else {
            echo "Invalid Route";
            exit();
        }
    }
}