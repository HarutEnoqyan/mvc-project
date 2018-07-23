<?php

namespace App\Controllers;

class MainController
{
    public function actionIndex() {
        global $pdh;
        $tables=[];
        $sql = 'show tables';
        query($sql);
        foreach (query($sql) as $row) {
            $tables[]=$row["Tables_in_".DATABASE_NAME];
        }
        view('welcome',$tables);
    }

    public function actionLogin() {
        view('login');
    }

    public function actionRegister() {

        view('register');
    }
}