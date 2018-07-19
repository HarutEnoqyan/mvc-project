<?php

namespace App\Controllers;
use App\Models\User;


class UserController
{

    public function actionIndex(){
        view('//user//welcome');
    }

    public  function actionCreate() {
        $user = new User();
        $user->create();
        $userName = $_POST['first_name'];
        header("Location: ".route('user/check' ,['name' => $userName])." ");
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
            header("Location: ".route('user/index' ,['name' => $name , 'token'=>$token])." ");
        } else {
            header("Location: ".route('main/login')." ");
        }
    }

    public function actionLogout() {
        session_start();
        session_destroy();
        redirect(route('main/index'));
    }
}