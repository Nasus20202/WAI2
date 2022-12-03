<?php
namespace routing;
require_once('controllers/PhotoController.php');

class Route {
    public $controllerName;
    public $controller;
    public $controllerFile;
    public function __construct($controllerName, $controller, $controllerFile = null){
        $this->controllerName = $controllerName;
        $this->controller = $controller;
        if($controllerFile == null){
            $this->controllerFile = 'controllers/'. ucfirst($controllerName) . 'Controller.php';
        }else 
            $this->controllerFile = $controllerFile;
    }
}

abstract class Routes {
    // routes definition
    private static function getRoutes(){
        return array(
            new Route('photo', \controllers\PhotoController::class),
            new Route('account', \controllers\AccountController::class)
        );
    }
    public static function getController(&$controllerName, &$action){
        $routes = Routes::getRoutes();
        foreach($routes as $route){
            if($route->controllerName == $controllerName)
                return $route;
        }
        // route for default controller
        $action = $controllerName;
        $controllerName = FrontController::DEFAULT_CONTROLLER;
        return $routes[0];
    }
}

