<?php
namespace models\Account;

use controllers\PhotoController;
use models\BaseModel;
require_once(__DIR__.'/../BaseModel.php');

class IndexModel extends BaseModel {
    public $login;
    public $password;
    public function __construct($login, $password, $status = 0){
        parent::__construct($status);
        $this->login = $login;
        $this->password = $password;
    }
}