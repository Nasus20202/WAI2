<?php
namespace models\Account;

use controllers\PhotoController;
use models\BaseModel;
require_once(__DIR__.'/../BaseModel.php');

class RegisterModel extends BaseModel {
    public $login;
    public $email;
    public $password;
    public function __construct($login, $email, $password, $status = 0){
        parent::__construct($status);
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
    }
}