<?php
namespace database;

class User {
    public $id;
    public $username;
    public $passwordHash;
    public $email;

    public function __construct($username, $email, $passwordHash, $id = null){
        $this->id = $id;
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->email = $email;
    }
}