<?php
namespace Core;
use App\Models\User;
class Auth {
    public static function checkIfAuth()
    {
        if (session_id()===''){
            session_start();
        }
        if($_SESSION && isset($_SESSION['token']) && isset($_SESSION['id'])){
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
        if ($_SESSION && isset($_SESSION['id'])){
            return $_SESSION['id'];
        }
    }

    public static function getFullName() {
        if (session_id()===''){
            session_start();
        }
        if ($_SESSION && isset($_SESSION['id'])){
            $id = $_SESSION['id'];
        }

        $user = new User();
        $person =  $user->where("id = $id")->first();
        $first_name = $person->attributes['first_name'];
        $last_name = $person->attributes['last_name'];
        return $first_name . ' ' . $last_name;


    }


}