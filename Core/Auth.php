<?php
namespace Core;
class Auth {
    public static function checkIfAuth()
    {
        session_start();

        if($_SESSION && $_SESSION['token'] && $_SESSION['id']){
            return true;
        } else {
            return false;
        }
    }

    public static function logOut()
    {
        session_start();
        session_destroy();
    }


}