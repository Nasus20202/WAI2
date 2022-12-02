<?php
namespace controllers;
require_once('Controller.php');

class PhotoController extends Controller implements IController {
    public function index(){
        echo 'PhotoController index';
    }
    public function dispatch(){
        echo 'PhotoController dispatch ' . $this->getAction();
    }
}