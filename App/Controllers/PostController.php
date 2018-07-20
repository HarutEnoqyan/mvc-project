<?php
namespace App\Controllers;
use App\Models\Post;
use Core\Auth;

class PostController {

    public function actionIndex()
    {
        if(Auth::checkIfAuth()){
            $posts= new Post();

//            dd($posts->get());
            $data = $posts
                ->select('posts.*, users.id as user_id, users.first_name, users.last_name')
                ->join('users', 'users.id',  '=', 'posts.user_id')
                ->get();

            view("Posts/index", $data );
        } else{
            redirect('/');
        }
    }

    public function actionCreate()
    {
        view('\\posts\\create');
    }

    public function actionSave() {
        session_start();
        $posts= new Post();
        $posts->attributes['title']=$_REQUEST['title'];
        $posts->attributes['content']=$_REQUEST['content'];
        $posts->attributes['created_at']=date("Y-m-d H:i:s");
        $posts->attributes['user_id']=$_SESSION['id'];
        $posts->insert();
        redirect(route('post/index'));
    }
}