<?php
class Auth
{
    // Kiem tra dang nhap
    public static function isLoggedIn()
    {
        return isset($_SESSION["logged_in"]) && $_SESSION["logged_in"];
    }

    // Bat buoc phai dang nhap
    public static function requireLogin()
    {
        if (!static::isLoggedIn()) {
            Redirect::to('login');
            exit();
        }
    }

    // Xu ly dang nhap
    public static function login()
    {
        session_regenerate_id(true);
        $_SESSION["logged_in"] = true;
    }

    // Xu ly dang xuat
    public static function logout()
    {
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy();
    }

    public static function isAdmin(){
        if(!($_SESSION['role_id'] == 1)){
            return false;
        }
        return true;
    }

    public static function isManager(){
        if(!($_SESSION['role_id'] == 3)){
            return false;
        }
        return true;
    }
    public static function isUser(){
        if(!($_SESSION['role_id'] == 2)){
            return false;
        }
        return true;
    }
}
