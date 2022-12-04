<?php
namespace models;

class BaseModel {
    public $userLoggedIn;
    public $username;
    public $userEmail;
    public $message;
    public function __construct($message = "", $userLoggedIn = false, $username = null, $userEmail = null){
        $this->message = $message;
        $this->userLoggedIn = $userLoggedIn;
        $this->username = $username;
        $this->userEmail = $userEmail;
    }
}