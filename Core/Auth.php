<?php
namespace Core;
class Auth {
    public static function checkIfAuth()
    {
        if (session_id()===''){
            session_start();
        }
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
        session_abort();
    }

    public static function getId()
    {
        if (session_id()===''){
            session_start();
        }
        return $_SESSION['id'];
    }


}