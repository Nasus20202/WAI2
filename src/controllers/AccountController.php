<?php
namespace controllers;


require_once('Controller.php');

class AccountController extends Controller implements IController {
    public function index(){
        $this->render();
    }
    public function dispatch(){
        switch($this->getAction()){
            case 'test':
                echo 'Account test';
                break;
            default:
                $this->setAction(\routing\FrontController::DEFAULT_ACTION);
                $this->index();
                break;
        }
    }
}