<?php
namespace models\Account;

use controllers\PhotoController;
use models\BaseModel;
require_once(__DIR__.'/../BaseModel.php');

class IndexModel extends BaseModel {
    public $login;
    public $password;
    public function __construct($login, $password, $status = 0, $userLoggedIn = false, $username = null, $userEmail = null){
        parent::__construct($status, $username, $userEmail);
        $this->login = $login;
        $this->password = $password;
    }
}