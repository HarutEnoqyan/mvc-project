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
        header("Location: ".route('user/index' ,['name' => $userName])." ");
    }

    public function actionCheck() {
        $user = new User();
        if ($user->login()){
            $name = $user->login()[0]->getAttributes()['first_name'];
            header("Location: ".route('user/index' ,['name' => $name])." ");
        } else {
            header("Location: ".route('main/login')." ");
        }
    }
}