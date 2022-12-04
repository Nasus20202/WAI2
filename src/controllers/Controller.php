<?php
namespace controllers;
require_once('../database/Database.php');

interface IController {
    public function index();
    public function dispatch();
    public function render($model, $view);
}

class Controller {
    protected $controllerName, $action;
    public function __construct($name, $action)
    {
        $this->setAction($action);
        $this->setControllerName($name);
    }
    public function render($model = null, $view = null){
        if($view == null){
            require_once('../views/'. ucfirst($this->getControllerName()). '/' . ucfirst($this->getAction()) . 'View.php');
        }
        else {
            require_once($view);
        }
    }
    public function getAction(){
        return $this->action;
    }
    public function getControllerName(){
        return $this->controllerName;
    }
    protected function setAction($action = \routing\FrontController::DEFAULT_ACTION){
        $this->action = $action;
    }
    protected function setControllerName($name = \routing\FrontController::DEFAULT_CONTROLLER){
        $this->controllerName = $name;
    }
}