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
            $userId = $_SESSION['id'];
            $uncheckedToken = $_SESSION['token'];
            $user = new User();
            $token = $user ->select('token')->where("id = $userId")->first()->attributes['token'];
            if ($uncheckedToken===$token) {
                return true;
            }else{
                return false;
            }
        } else {
            return false;
        }
    }

    public static function logOut()
    {
        unset($_COOKIE['my_id']);
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
        return false;

    }

    public static function getFullName() {
        if (session_id()===''){
            session_start();
        }
        if ($_SESSION && isset($_SESSION['id'])){
            $id = $_SESSION['id'];
            $user = new User();
            $person =  $user->where("id = $id")->first();
            $first_name = $person->attributes['first_name'];
            $last_name = $person->attributes['last_name'];
            return $first_name . ' ' . $last_name;
        }
        return false;

    }


}