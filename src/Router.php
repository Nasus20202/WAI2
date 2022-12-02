<?php
namespace routing;
require_once('Routes.php');

class Router {
    public function dispatch($controller, $action){
        $routeInfo = Routes::getController($controller);
        require_once($routeInfo->controllerFile);
        $controller = new $routeInfo->controller($action);
        $controller->dispatch();
    }
}