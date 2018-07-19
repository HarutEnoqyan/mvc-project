<?php
 namespace App\Models;
 use Core\ORM;

 class User  extends ORM {
     protected $table = 'users';

     public function create() {
         global $pdh;

         $first_name = '"'. $_POST['first_name'].'"';
         $last_name = '"'.$_POST['last_name'].'"';
         $age = '"'.$_POST['age'].'"';
         $email ='"'. $_POST['email'].'"';
         $password = '"'.$_POST['password'].'"';
         $created_at = '"'.date("Y-m-d H:i:s").'"';

         $sql = "INSERT INTO users(first_name, last_name, date_of_birth, email, password, created_at)
    VALUES ($first_name , $last_name , $age , $email , $password , $created_at); ";
//        dd($sql);
         try {
             $pdh->prepare($sql);
             $a = $pdh->query($sql);
             if (!$a){
                 dd($pdh->errorInfo()[2]);
             }
         } catch (\Exception $e) {
             echo 'Caught exception: ',  $e->getMessage(), "\n";
         }

     }

     public function login() {
         global $pdh;

         $email = '"'. $_POST['email'].'"';
         $password = $_POST['password'];
         $user = $this->where("email=$email")->get();

         if($user && $user[0]->attributes['password']==$password) {
             return $user;
         } else  {
             return ;
         }



     }
 }
