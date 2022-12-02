<?php
namespace controllers;
require_once('Controller.php');

class AccountController extends Controller implements IController
{
    public function index()
    {
        echo 'AccountController index';
    }
    public function dispatch()
    {
        echo 'AccountController dispatch ' . $this->getAction();
    }
}