<?php
namespace controllers;
use models\BaseModel;
use routing\Router;
use database\Database;
use models\Account;
require_once('Controller.php');

class AccountController extends Controller implements IController {
    public function index(){
        $this->loadModel();
        if($this->method == "POST"){
            $model = new \models\Account\IndexModel($_POST['login'], $_POST['password'], "Zaloguj się", "", 3);
            $credentailsValidation = $this->checkCredentials($model->login, $model->password);
            if($credentailsValidation == 0){
                Router::redirect();
            } else{
                Router::redirectToUrl('/account/login?error='.$credentailsValidation);
            }
        } else {
            $error = isset($_GET['error']) ? $_GET['error'] : 0;
            $model = new BaseModel("Zaloguj się", "", 3);
            switch($error){
                case 1:
                    $model->message = "Błędne dane logowania"; break;
            }
            $this->render($model);
        }
    }
    public function checkCredentials($login, $password){
        $db = new Database();
        return 1;
    }
    public function dispatch(){
        switch($this->getAction()){
            case 'test':
                echo 'Account test';
                break;
            default:
                $this->setAction(); // set dafault action
                $this->index();
                break;
        }
    }
}