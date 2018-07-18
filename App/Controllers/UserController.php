<?php

namespace App\Controllers;


class UserController
{
    public function actionIndex(){
        echo "user/index";
    }

    public  function actionCreate() {
        var_dump($_POST);
    }
}