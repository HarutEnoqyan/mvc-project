<?php

namespace App\Controllers;
use Models\User;


class UserController
{
    public function actionIndex(){
        // dd($name);
        view('//user//welcome');
    }

    public  function actionCreate() {
        $user = new User();
        $user->create();
        $userName = $_POST['first_name'];
        header("Location: ".route('user/index' ,['name' => $userName])." ");
    }
}