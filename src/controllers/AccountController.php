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
    public function index(){
        $title = "Zaloguj się"; $pageId = 3;
        $this->loadModel();
        if($this->method == "POST"){
            $model = new \models\Account\IndexModel(strtolower($_POST['login']), $_POST['password'], $title);
            $credentailsValidation = $this->login($model->login, $model->password);
            if($credentailsValidation == 0){
                Router::redirect();
            } else{
                Router::redirectToUrl('/account/login?error='.$credentailsValidation);
            }
        } else {
            $error = isset($_GET['error']) ? $_GET['error'] : 0;
            $model = new BaseModel($error);
            $this->render($model);
        }
    }

    public function register(){
        $this->loadModel();
        if($this->method == "POST"){
            $model = new \models\Account\RegisterModel(strtolower($_POST['login']), $_POST['email'], $_POST['password']);
            $status = $this->createUser($model->login, $model->email, $model->password);
            if($status == 0){
                Router::redirect();
            } else{
                Router::redirectToUrl('/account/register?error='.$status);
            }
        } else {
            $error = isset($_GET['error']) ? $_GET['error'] : 0;
            $model = new BaseModel($error);
            $this->render($model);
        }
    }

    public function logout(){
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
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 3;
        }
        else if(strlen($password) < 8){
            return 4;
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