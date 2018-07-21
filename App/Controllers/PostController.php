<?php
namespace App\Controllers;
use App\Models\Post;
use Core\Auth;
use Core\Validation;

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
        $posts= new Post();

        if (Validation::validateTitle($_REQUEST['title'])=== true){
            $posts->attributes['title']=$_REQUEST['title'];
        }else{
           $error = Validation::validateTitle($_REQUEST['title']);
           dd($error);
        }

        if (Validation::validateContent($_REQUEST['content'])===true){
            $posts->attributes['content']=$_REQUEST['content'];
        }else {
           $error =  Validation::validateContent($_REQUEST['content']);
           dd($error);
        }

        $posts->attributes['created_at']=date("Y-m-d H:i:s");
        $posts->attributes['user_id']=Auth::getId();
        $posts->insert();
        redirect(route('post/index'));
    }

    public function actionShow() {
        $id = $_GET['id'];
        $posts= new Post();
        $data = $posts
            ->select('posts.*, users.id as user_id, users.first_name, users.last_name')
            ->join('users', 'users.id',  '=', 'posts.user_id')
            ->where("posts.id = $id")
            ->first()->attributes;

        view("Posts/show", $data );

    }

    public function actionDelete() {
        $id = $_GET['id'];
        $posts= new Post();
        $data = $posts->select('user_id')->where("id=$id")->first()->attributes;
        if($data['user_id']==Auth::getId()){
            $posts->where("id = $id")
                ->delete();
            redirect(route('post/index'));
        }else {
            redirect(route('post/index'));
        }


    }

    public function actionEdit() {
        $id = $_GET['id'];
        $posts= new Post();
        $data = $posts
            ->select('posts.*, users.id as user_id, users.first_name, users.last_name')
            ->join('users', 'users.id',  '=', 'posts.user_id')
            ->where("posts.id = $id")
            ->first()->attributes;
        if($data['user_id']==Auth::getId()){
            view("Posts/edit", $data );
        }else {
            redirect(route('post/index'));
        }

    }

    public function actionUpdate() {
        $id = $_GET['id'];
        $posts= new Post();
        $title=$_REQUEST['title'];
        $content=$_REQUEST['content'];
        $posts->where("id=$id")
              ->set(['title','content','updated_at'],["$title" , "$content", date("Y-m-d H:i:s")])
              ->update();
        redirect(route('post/index'));
    }

    public function actionTest()
    {
        dd(Validation::validateDate("2018.07-19 10:32:44"));
    }
}