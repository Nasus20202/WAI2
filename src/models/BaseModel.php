<?php
namespace models;

use auth\Auth;


class BaseModel {
    public $userLoggedIn;
    public $username;
    public $userEmail;
    public $userId;
    public $status;
    public function __construct($status = 0){
        $this->status = $status;
        $this->userLoggedIn = Auth::isUserLoggedIn();
        $this->username = Auth::getUsersName();
        $this->userEmail = Auth::getUsersEmail();
        $this->userId = Auth::getUserId();
    }
}