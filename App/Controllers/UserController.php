<?php

namespace App\Controllers;
use App\Models\User;
use Core\Auth;
use Core\Validation;
use App\Controllers\FriendController;



class UserController
{
    public $validationErrors = [];
    public $oldValues = [];

    public function actionIndex(){
        view("//user//welcome");
    }

    public  function actionCreate() {
        $user = new User();
        $token = md5(rand());
        $first_name = '';
        $last_name = '';
        $age = '';
        $password='';
        $fileName='';
        $unchekedValues = [
            'name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'age' => $_POST['age'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];

        if ($_SERVER['REQUEST_METHOD']==='POST') {
            if (Validation::validateName($_POST['first_name'])===true) {
                $first_name =  $_POST['first_name'];
            } else {
                $this->validationErrors['name']= Validation::validateName($_POST['first_name']);
            }

            if (Validation::validateLastName($_POST['last_name'])===true) {
                $last_name = $_POST['last_name'];
            }else {
                $this->validationErrors['last_name']= Validation::validateLastName($_POST['last_name']);
            }

            if (Validation::validateDate($_POST['age'])===true) {
                $age = $_POST['age'];
            } else {
                $this->validationErrors['age'] =Validation::validateDate($_POST['age']) ;
            }

            if (Validation::validateEmail($email =$_POST['email'])===true) {
                $email =$_POST['email'];
            }else {
                $this->validationErrors['email'] = Validation::validateEmail($email =$_POST['email']);
            }

            if (Validation::validatePass($_POST['password'])===true) {
                $password = $_POST['password'];
            }else {
                $this->validationErrors['password']=Validation::validatePass($_POST['password']);
            }

            function random_string($length) {
                $key = '';
                $keys = array_merge(range(0, 9), range('a', 'z'));

                for ($i = 0; $i < $length; $i++) {
                    $key .= $keys[array_rand($keys)];
                }

                return $key;
            }

            $type = $_FILES['avatar']['type'];
            $tempName = $_FILES['avatar']['tmp_name'];


            if (count($this->validationErrors)===0){

                if (isset($type)) {
                    if (!empty($type)) {
                        $type = str_replace(substr($type,0,6), ".",$type);
                        $fileName = random_string(20);
                        $location = 'images/uploads/';
                        move_uploaded_file($tempName , $location.$fileName.$type );
                    }
                }


                $created_at =date("Y-m-d H:i:s");
                $user->attributes['first_name']=$first_name;
                $user->attributes['last_name']=$last_name;
                $user->attributes['date_of_birth']=$age;
                $user->attributes['email']=$email;
                $user->attributes['password']=$password;
                $user->attributes['token']=$token;
                $user->attributes['created_at']=$created_at;
                if ($fileName) {
                    $user->attributes['avatar']=$fileName.$type;
                }
                    $user->insert();

                $userName = $first_name;
                $userId = $user->select('id')->where("email="."'".$email."'"." ")->first()->attributes['id'];
                session_start();
                $_SESSION['token']=$token;
                $_SESSION['id']=$userId;
                $_SESSION['name']=$userName;
                if ($fileName) {
                    $_SESSION['avatar']=$fileName.$type;
                }
                redirect(route('user/Index' ));
            } else {
                if (count($this->validationErrors) > 0) {
                    session_start();
                    $_SESSION['errors'] = $this->validationErrors;
                    $_SESSION['old'] = $unchekedValues;

//                    dd($_SESSION['errors']);
                    redirect(route('main/register'));
                }
            }
        } else {
            redirect(route('main/register'));
        }

    }

    public function actionCheck() {
        $email='';
        $password='';
        $unchekedValues = [
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (Validation::validateEmail($email =$_POST['email'])===true) {
                $email ="'".$_POST['email']."'";
            }else {
                $this->validationErrors['email'] = Validation::validateEmail($email =$_POST['email']);
            }

            if (Validation::validatePass($_POST['password'])===true) {
                $password = $_POST['password'];
            }else {
                $this->validationErrors['password']=Validation::validatePass($_POST['password']);
            }
        }


        if (count($this->validationErrors)==0){
            $users = new User;
            $user = $users->where("email=$email")->first()->attributes;
//            dd($user);
            if (isset($user) && $user['password']===$password){
                $token = md5(rand());
                $userId = $user['id'];
                $userName = $user['first_name'];
                $avatar = $user['avatar'];
                session_start();
                $_SESSION['token']=$token;
                $_SESSION['id']=$userId;
                $_SESSION['name']=$userName;
                $_SESSION['avatar']=$avatar;
                $this->updateToken($userId,$token);
                $friends = \App\Controllers\FriendController::initFriends();
                $_SESSION['friends'] = $friends;
                redirect(route('user/index' ));
            } else {
                session_start();
                $_SESSION['old'] = $unchekedValues;
                $_SESSION['login_error'] = 'Invalid email or password';
                redirect(route('main/login'));
            }
        }else {
            session_start();
            $_SESSION['errors'] = $this->validationErrors;
            $_SESSION['old'] = $unchekedValues;
            redirect(route('main/login'));
        }

    }

    public function updateToken($id,$token)
    {
        $user = new User();
        $user->where("id = $id")->set(['token'],[$token])->update();
    }

    public function actionLogout()
    {
        Auth::logOut();
        redirect(route('main/index'));
    }

    public function actionShow()
    {
        $users = new User();
        $data = $users
            ->where("id!=".Auth::getId()."")
            ->get();

        view('user/show' , $data);
    }


}

