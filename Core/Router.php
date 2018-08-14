<?php

namespace Core;
use Core\checkRoute as checking;

class Router {
    public static function init()
    {
        $route = 'main/index';

        if (checking::check()===false) {
            redirect(route('main/errorPage'));
        }

        if ($_SERVER['REQUEST_URI'] && substr(explode('?' ,$_SERVER['REQUEST_URI'])[0], 1) !="") {
            $route = substr(explode('?' ,$_SERVER['REQUEST_URI'])[0], 1);
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