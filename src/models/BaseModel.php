<?php
namespace models;

class BaseModel {
    public $userLoggedIn;
    public $username;
    public $userEmail;
    public $message;
    public $pageTitle;
    public function __construct($pageTitle = "", $message = "", $userLoggedIn = false, $username = null, $userEmail = null){
        $this->pageTitle = $pageTitle;
        $this->message = $message;
        $this->userLoggedIn = $userLoggedIn;
        $this->username = $username;
        $this->userEmail = $userEmail;
    }
}