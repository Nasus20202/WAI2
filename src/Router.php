<?php
namespace routing;
require_once('Routes.php');

class Router {
    public function dispatch($controller, $action){
        $routeInfo = Routes::getController($controller, $action);
        require_once($routeInfo->controllerFile);
        $controller = new $routeInfo->controller($routeInfo->controllerName, $action);
        $controller->dispatch();
    }
}