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
    public static function getController($controllerName){
        // routes definition
        $routes = array(
            new Route('photo', \controllers\PhotoController::class),
            new Route('account', \controllers\AccountController::class)
        );
        foreach($routes as $route){
            if($route->controllerName == $controllerName)
                return $route;
        }
        return null;
    }
}

