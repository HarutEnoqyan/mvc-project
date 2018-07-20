<?php
namespace App\Controllers;
use App\Models\Post as posts;
use Core\Auth;

class PostController {
    public function actionIndex()
    {
        if(Auth::checkIfAuth()){
            $posts = new posts();
//            dd($posts->get());
            $data = $posts
                ->select('posts.*, users.id as user_id, users.first_name, users.last_name')
                ->join('users', 'users.id',  '=', 'posts.user_id')
                ->get();

            view("\\Posts\\index", $data );
        } else{
            redirect('/');
        }
    }
}