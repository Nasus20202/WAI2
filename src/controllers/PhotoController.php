<?php
namespace controllers;


require_once('Controller.php');

class PhotoController extends Controller implements IController {
    public function index(){
        $this->render();
    }
    public function dispatch(){
        switch($this->getAction()){
            case 'test':
                echo 'Photo test';
                break;
            default:
                $this->setAction(\routing\FrontController::DEFAULT_ACTION);
                $this->index();
                break;
        }
    }
}