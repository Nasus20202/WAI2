<?php
namespace controllers;
use routing\Router;
use database\Database;
require_once('Controller.php');

class AccountController extends Controller implements IController {
    public function index(){
        $db = new Database();
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