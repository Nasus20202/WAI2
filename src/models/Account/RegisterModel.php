<?php
namespace models\Account;

use controllers\PhotoController;
use models\BaseModel;
require_once(__DIR__.'/../BaseModel.php');

class RegisterModel extends BaseModel {
    public $login;
    public $email;
    public $password;
    public function __construct($login, $email, $password, $pageTitle = "", $message = "", $pageId = 0, $userLoggedIn = false, $username = null, $userEmail = null){
        parent::__construct($pageTitle, $message, $pageId, $userLoggedIn, $username, $userEmail);
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
    }
}