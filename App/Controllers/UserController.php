<?php

namespace App\Controllers;
use App\Models\User;
use Core\Auth;
use Core\Validation;



class UserController
{

    public function actionIndex(){
        view('//user//welcome');
    }

    public  function actionCreate() {
        $user = new User();
        $token = md5(rand());
        if (Validation::validateName($_POST['first_name'])===true) {
            $first_name =  $_POST['first_name'];
        } else {
            $error = Validation::validateName($_POST['first_name']);
            dd($error);
        }

        if (Validation::validateName($_POST['last_name'])===true) {
            $last_name = $_POST['last_name'];
        }else {
            $error = Validation::validateName($_POST['last_name']);
            dd($error);
        }

        if (Validation::validateDate($_POST['age'])===true) {
            $age = $_POST['age'];
        } else {
            $error = Validation::validateDate($_POST['age']);
            dd($error);
        }

        if (Validation::validateEmail($email =$_POST['email'])===true) {
            $email =$_POST['email'];
        }else {
            $error = Validation::validateEmail($email =$_POST['email']);
            dd($error);
        }

        if (Validation::validatePass($_POST['password'])===true) {
            $password = $_POST['password'];
        }else {
            $error = Validation::validatePass($_POST['password']);
            dd($error);
        }

        $created_at =date("Y-m-d H:i:s");
        $user->attributes['first_name']=$first_name;
        $user->attributes['last_name']=$last_name;
        $user->attributes['date_of_birth']=$age;
        $user->attributes['email']=$email;
        $user->attributes['password']=$password;
        $user->attributes['token']=$token;
        $user->attributes['created_at']=$created_at;
        $user->insert();

        $userName = $first_name;
        $userId = $user->select('id')->where("email="."'".$email."'"." ")->first()->attributes['id'];
        session_start();
        $_SESSION['token']=$token;
        $_SESSION['id']=$userId;
        $_SESSION['name']=$userName;
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