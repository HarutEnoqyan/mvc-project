<?php

namespace App\Controllers;
use App\Models\User;
use Core\Auth;


class UserController
{

    public function actionIndex(){
        view('//user//welcome');
    }

    public  function actionCreate() {
        $user = new User();
        $user->create();
        $token = md5(rand() );
        $userName = $user->login()->getAttributes()['first_name'];
        $userId = $user->login()->getAttributes()['id'];
        session_start();
        $_SESSION['token']=$token;
        $_SESSION['id']=$userId;
        $_SESSION['name']=$userName;
        $user->updateToken($userId,$token);
        header("Location: ".route('user/Index' )." ");
    }

    public function actionCheck() {

        $user = new User();
        if (  $user->login()  ){
            $token = md5(rand() );
            $userId = $user->login()->getAttributes()['id'];
            $userName = $user->login()->getAttributes()['first_name'];
            session_start();
            $_SESSION['token']=$token;
            $_SESSION['id']=$userId;
            $_SESSION['name']=$userName;
            $user->updateToken($userId,$token);


            header("Location: ".route('user/index' )." ");
        } else {
            header("Location: ".route('main/login')." ");
        }
    }

    public function actionLogout() {
        Auth::logOut();
        redirect(route('main/index'));
    }
}