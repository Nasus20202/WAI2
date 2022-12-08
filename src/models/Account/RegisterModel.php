<?php
namespace models\Account;

use controllers\PhotoController;
use models\BaseModel;
require_once(__DIR__.'/../BaseModel.php');

class RegisterModel extends BaseModel {
    public $login;
    public $email;
    public $password;
    public $passwordRepeat;
    public function __construct($login, $email, $password, $passwordRepeat, $status = 0){
        parent::__construct($status);
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
    }
}