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
        $userName = $_POST['first_name'];
        $token = md5(rand() );
        $userId = $user->login()->getAttributes()['id'];
        session_start();
        $_SESSION['token']=$token;
        $_SESSION['id']=$userId;
//            dd($_SESSION);
        $user->updateToken($userId,$token);
        header("Location: ".route('user/Index' ,['name' => $userName])." ");
    }

    public function actionCheck() {

        $user = new User();
        if (  $user->login()  ){
            $token = md5(rand() );
            $userId = $user->login()->getAttributes()['id'];
            session_start();
            $_SESSION['token']=$token;
            $_SESSION['id']=$userId;
//            dd($_SESSION);
            $user->updateToken($userId,$token);

            $name = $user->login()->getAttributes()['first_name'];
            header("Location: ".route('user/index' ,['name' => $name ])." ");
        } else {
            header("Location: ".route('main/login')." ");
        }
    }

    public function actionLogout() {
        Auth::logOut();
        redirect(route('main/index'));
    }
}