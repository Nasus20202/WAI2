<?php
namespace controllers;

interface IController {
    public function index();
    public function dispatch();
}

class Controller {
    protected $action;
    public function __construct($action)
    {
        $this->setAction($action);
    }
    public function getAction(){
        return $this->action;
    }
    public function setAction($action){
        $this->action = $action;
    }
}