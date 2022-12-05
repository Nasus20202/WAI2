<?php
namespace models;

class BaseModel {
    public $userLoggedIn;
    public $username;
    public $userEmail;
    public $status;
    public function __construct($status = 0, $userLoggedIn = false, $username = null, $userEmail = null){
        $this->status = $status;
        $this->userLoggedIn = $userLoggedIn;
        $this->username = $username;
        $this->userEmail = $userEmail;
    }
}