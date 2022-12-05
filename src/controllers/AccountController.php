<?php
namespace controllers;
use models\BaseModel;
use routing\Router;
use database\Database;
use database\User;
use models\Account;
require_once('Controller.php');

class AccountController extends Controller implements IController {
    public function index(){
        $title = "Zaloguj się"; $pageId = 3;
        $this->loadModel();
        if($this->method == "POST"){
            $model = new \models\Account\IndexModel($_POST['login'], $_POST['password'], $title, "", $pageId);
            $credentailsValidation = $this->login($model->login, $model->password);
            if($credentailsValidation == 0){
                Router::redirect();
            } else{
                Router::redirectToUrl('/account/login?error='.$credentailsValidation);
            }
        } else {
            $error = isset($_GET['error']) ? $_GET['error'] : 0;
            $model = new BaseModel($title, "", $pageId);
            switch($error){
                case 1:
                    $model->message = "Użytkownik nie istnieje"; break;
                case 2:
                    $model->message = "Błędne hasło"; break;
            }
            $this->render($model);
        }
    }

    public function register(){
        $title = "Zarejestruj się"; $pageId = 3;
        $this->loadModel();
        if($this->method == "POST"){
            $model = new \models\Account\RegisterModel($_POST['login'], $_POST['email'], $_POST['password'], $title, "", $pageId);
            $status = $this->createUser($model->login, $model->email, $model->password);
            if($status == 0){
                Router::redirect();
            } else{
                Router::redirectToUrl('/account/register?error='.$status);
            }
        } else {
            $error = isset($_GET['error']) ? $_GET['error'] : 0;
            $model = new BaseModel($title, "", $pageId);
            switch($error){
                case 1:
                    $model->message = "Login jest już zajęty"; break;
                case 2:
                    $model->message = "Adres email jest już zajęty"; break;
            }
            $this->render($model);
        }
    }

    public function dispatch(){
        switch($this->getAction()){
            case 'register':
                $this->register(); break;
            default:
                $this->setAction(); // set dafault action
                $this->index();
                break;
        }
    }

    public function checkCredentials($login, $password){
        $db = new Database();
        $user = $db->getUserByUsername($login);
        if($user == null)
            return 1;
        else if ($user->passwordHash != AccountController::hashPassword($password))
            return 2;
        return 0;
    }

    public function login($login, $password){
        $status = $this->checkCredentials($login, $password);
        if($status == 0){
            $db = new Database();
            $user = $db->getUserByUsername($login);
            $_SESSION['userId'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['email'] = $user->email;
        }
        return $status;
    }

    public function createUser($login, $email, $password){
        $user = new User($login, $email, AccountController::hashPassword($password));
        $db = new Database();
        if($db->getUserByUsername($login) != null)
            return 1;
        else if($db->getUserByEmail($email) != null)
            return 2;
        $db->createUser($user);
        $login($login, $password);
        return 0;
    }

    public static function hashPassword($password){
        return hash("sha256", $password);
    }
}