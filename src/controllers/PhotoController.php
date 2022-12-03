<?php
namespace controllers;
use routing\Router;
require_once('Controller.php');

class PhotoController extends Controller implements IController {
    public function index(){
        $this->render();
    }
    public function dispatch(){
        switch($this->getAction()){
            case 'test':
                Router::redirect('account');
                break;
            default:
                $this->setAction(\routing\FrontController::DEFAULT_ACTION);
                $this->index();
                break;
        }
    }
}