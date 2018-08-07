<?php

namespace App\Controllers;
use Events\Message;
use Pusher;

class MainController
{
    public function actionIndex()
    {
        view('welcome');
    }

    public function actionLogin()
    {
        view('login');
    }

    public function actionRegister()
    {

        view('register');
    }

    public function actionErrorPage()
    {
        view('page_not_found');
    }
    public function actionTest()
    {
        view('socketTest');
    }

    public function actionMessage(){


        if (!empty($_POST['message'])){
            $data['message'] = $_POST['message'];
            new Message($data);
        }
    }

}