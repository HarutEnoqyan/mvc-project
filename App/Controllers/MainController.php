<?php

namespace App\Controllers;

class MainController
{
    public function actionIndex() {
        view('welcome');
    }

    public function actionLogin() {
        view('login');
    }

    public function actionRegister() {

        view('register');
    }
}