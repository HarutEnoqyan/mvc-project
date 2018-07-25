<?php
namespace App\Controllers;
use App\Models\Comment;
use Core\Auth;
use Core\Validation;

class CommentController {
    protected $validateErrors = [];
    protected $post_id = 0;
    protected $user_id = 0;

    public function actionCreate()
    {
        $this->user_id = Auth::getId();
        $this->post_id = $_POST['post_id'];
        $comment = new Comment();

        if (Validation::validateComment($_POST['comment'])===true) {
            $comment->attributes['content'] = $_POST['comment'];
        } else {
            $this->validateErrors['comment'] = Validation::validateComment($_POST['comment']);
        }

        if (count($this->validateErrors)===0) {
            $comment->attributes['created_at']=date("Y-m-d H:i:s");
            $comment->attributes['user_id']=$this->user_id;
            $comment->attributes['post_id']=$this->post_id;
            $comment->insert();
            $txt = "   <div class='comments-list border-bottom'>
                           <div class='media'>
                               <a class='media-left' href='#'>
                                   <!--                                <img src=\"http://lorempixel.com/40/40/people/1/\">-->
                               </a>
                               <div class='media-body'>

                                   <h4 class='media-heading user_name'> ". Auth::getFullName() ." </h4>
                                   ". $comment->attributes['content'] ."
                                   <small class='float-right'>". $comment->attributes['created_at'] ."</small>
                                   <p><small><a href=''>Reply</a></small></p>
                               </div>
                           </div>
                       </div>";
            echo json_encode($txt);
        }
    }

    public static function actionShow()
    {
        $comments = new Comment();
        $allCommetns =  $comments
            ->select('comments.*, users.first_name, users.last_name')
            ->join('users', 'users.id',  '=', 'comments.user_id')
            ->get();
        return $allCommetns;
    }
}