<?php
namespace App\Controllers;
use App\Models\Post;
use Core\Auth;

class PostController {
    public function actionIndex()
    {
        if(Auth::checkIfAuth()){
            view("\\Posts\\index");
        } else{
            redirect('/');
        }
    }
}