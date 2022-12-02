<?php
require '../../vendor/autoload.php';

// global settings
session_start();

// create front controller
$frontController = new FrontController();

class FrontController
{
    private $action;
    private $controller;
    // default route
    const DEFAULT_CONTROLLER = 'home';
    const DEFAULT_ACTION = 'index';

    public function __construct($controller = "", $action = "")
    {
        if($controller == "" || $action == "")
            $this->extractControllerAndAction();
        else {
            $this->controller = $controller;
            $this->action = $action;
        }
        if($this->controller == "")
            $this->controller = FrontController::DEFAULT_CONTROLLER;
        if($this->action == "")
            $this->action = FrontController::DEFAULT_ACTION;
        $this->serve($this->controller, $this->action);
    }

    private function extractControllerAndAction()
    {
        $route = substr($_GET['route'], 1);
        $splittedRoute = explode('/', $route, 2);
        $this->controller = count($splittedRoute) > 0 ? $splittedRoute[0] : "";
        $this->action = count($splittedRoute) > 1 ? $splittedRoute[1] : "";
    }

    public function serve($controller, $action){
        echo $controller . ' ' . $action;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getController()
    {
        return $this->controller;
    }
}

