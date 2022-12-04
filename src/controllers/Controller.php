<?php
namespace controllers;
require_once('../database/Database.php');

interface IController {
    public function index();
    public function dispatch();
    public function render($model, $view);
}

class Controller {
    protected $controllerName, $action, $method;
    public function __construct($name, $action)
    {
        $this->setAction($action);
        $this->setControllerName($name);
        $this->setMethod($_SERVER['REQUEST_METHOD']);
    }
    public function render($model = null, $view = null){
        if($view == null){
            require_once('../views/'. ucfirst($this->getControllerName()). '/' . ucfirst($this->getAction()) . 'View.php');
        }
        else {
            require_once($view);
        }
    }
    protected function loadModel($path = null){
        if($path == null){
            require_once('../models/'. ucfirst($this->getControllerName()). '/' . ucfirst($this->getAction()) . 'Model.php');
        }
        else {
            require_once($path);
        }
    }
    public function getAction(){
        return $this->action;
    }
    public function getControllerName(){
        return $this->controllerName;
    }
    public function getMethod(){
        return $this->method;
    }
    protected function setAction($action = \routing\FrontController::DEFAULT_ACTION){
        $this->action = $action;
    }
    protected function setControllerName($name = \routing\FrontController::DEFAULT_CONTROLLER){
        $this->controllerName = $name;
    }
    protected function setMethod($method){
        $this->method = $method;
    }
}