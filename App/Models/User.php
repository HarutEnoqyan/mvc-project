<?php
 namespace App\Models;
 use Core\ORM;

 class User  extends ORM {
     protected $table = 'users';

     public function login() {
         global $pdh;

         $email = '"'. $_POST['email'].'"';
         $password = $_POST['password'];
         $user = $this->where("email=$email")->first();


         if($user && $user->attributes['password']==$password) {

             return $user;
         } else  {
             return ;
         }

     }

     public function updateToken($id,$token)
     {
         $this->where("id = $id")->set("token",$token)->update('users');
     }
 }
