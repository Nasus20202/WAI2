<?php
namespace controllers;
use models\BaseModel;
use routing\Router;
use database\Database;
use database\User;
use models\Account;
use auth\Auth;
require_once('Controller.php');

class AccountController extends Controller implements IController {
    protected function index(){
        $this->loadModel();
        if($this->method == "POST"){
            $model = new \models\Account\IndexModel(strtolower($this->post('login')), $this->post('password'));
            $credentailsValidation = $this->login($model->login, $model->password);
            if($credentailsValidation == 0){
                Router::redirect();
            } else{
                Router::redirectToUrl('/account/login?error='.$credentailsValidation);
            }
        } else {
            if(Auth::isUserLoggedIn())
                Router::redirect();
            $error = $this->get('error');
            $model = new BaseModel($error);
            $this->render($model);
        }
    }

    protected function register(){
        $this->loadModel();
        if($this->method == "POST"){
            $model = new \models\Account\RegisterModel(strtolower($this->post('login')), strtolower($this->post('email')), $this->post('password'), $this->post('passwordRepeat'));
            $status = $this->createUser($model->login, $model->email, $model->password, $model->passwordRepeat);
            if($status == 0){
                Router::redirect();
            } else{
                Router::redirectToUrl('/account/register?error='.$status);
            }
        } else {
            $error = $this->get('error');
            $model = new BaseModel($error);
            $this->render($model);
        }
    }

    protected function logout(){
        Auth::clearAuthInfo();
        Router::redirect();
    }

    public function dispatch(){
        switch($this->getAction()){
            case 'register':
                $this->register(); break;
            case 'logout':
                $this->logout(); break;
            default:
                $this->setAction(); // set dafault action
                $this->index();
                break;
        }
    }

    protected function checkCredentials($login, $password){
        $db = new Database();
        $user = $db->getUserByUsername($login);
        if($user == null)
            return 1;
        else if ($user->passwordHash != AccountController::hashPassword($password))
            return 2;
        return 0;
    }

    protected function login($login, $password){
        $status = $this->checkCredentials($login, $password);
        if($status == 0){
            $db = new Database();
            $user = $db->getUserByUsername($login);
            Auth::setUsersId($user->id);
            Auth::setUsersName($user->username);
            Auth::setUsersEmail($user->email);
        }
        return $status;
    }

    protected function createUser($login, $email, $password, $passwordRepeat){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 3;
        }
        else if(strlen($password) < 8){
            return 4;
        }
        else if($password != $passwordRepeat){
            return 5;
        }
        $user = new User($login, $email, AccountController::hashPassword($password));
        $db = new Database();
        if($db->getUserByUsername($login) != null)
            return 1;
        else if($db->getUserByEmail($email) != null)
            return 2;
        $db->createUser($user);
        $this->login($login, $password);
        return 0;
    }

    public static function hashPassword($password){
        return hash("sha256", $password);
    }
}