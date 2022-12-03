<?php
namespace controllers;
use routing\Router;
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
                $this->setAction(); // set dafault action
                $this->index();
                break;
        }
    }
}