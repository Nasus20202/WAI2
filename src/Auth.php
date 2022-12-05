<?php

class Auth{
    const username = 'username';
    const email = 'email';
    const userId = 'userId';
    public static function getUsersName(){
        return Auth::getFromSession(Auth::username);
    }
    public static function getUsersEmail(){
        return Auth::getFromSession(Auth::email);
    }
    public static function getUserId(){
        return Auth::getFromSession(Auth::username);
    }
    public static function setUsersName($name = null){
        Auth::setSession(Auth::username, $name);
    }
    public static function setUsersEmail($email = null){
        Auth::setSession(Auth::email, $email);
    }
    public static function setUsersId($id = null){
        Auth::setSession(Auth::userId, $id);
    }
    public static function clearAuthInfo(){
        Auth::setUsersName(); Auth::setUsersEmail(); Auth::setUsersId();
    }

    protected static function getFromSession($id){
        return isset($_SESSION[$id])?$_SESSION[$id]:null;
    }
    protected static function setSession($id, $value = null){
        if($value == null)
            unset($_SESSION[$id]);
        else
            $_SESSION[$id] = $value;
    }
}