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
    public static function redirect($controller = FrontController::DEFAULT_CONTROLLER, $action = FrontController::DEFAULT_ACTION){
        $url = FrontController::BASE_URL . $controller . '/' . ($action == FrontController::DEFAULT_ACTION ? '' : $action);
        Router::redirectToUrl($url);
    }
    public static function redirectToUrl($url){
        header('Location: ' . $url);
        die();
    }
}