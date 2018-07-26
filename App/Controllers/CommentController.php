<?php
namespace App\Controllers;
use App\Models\Comment;
use Core\Auth;
use Core\ORM;
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
            $id = $comment->where("created_at="."'".$comment->attributes['created_at']."'"."")->first()->attributes['id'];

            $txt = "   <div class='comments-list border-bottom'>
                           <div class='media'>
                               <a class='media-left' href='#'>
                                   <!--                                <img src=\"http://lorempixel.com/40/40/people/1/\">-->
                               </a>
                               <div class='media-body'>

                                   <h4 class='media-heading user_name'> ". Auth::getFullName() ." </h4>
                                   ". $comment->attributes['content'] ."
                                   <small class='float-right'>". $comment->attributes['created_at'] ."</small>
                                   <div>
                                        <button class='btn btn-primary btn-sm' type='button' data-toggle='collapse' data-target='#CollapseReply".$id."' aria-expanded='false' aria-controls='collapseExample'>
                                            <small>Reply</small>
                                        </button>
                                        <div class='com-md-12 collapse' id='CollapseReply".$id."'>
                                            <div class='form-group row mt-2'>
                                                <input name='comment_reply' type='text' class=' ml-3 ajax_reply_input form-control col-md-11' placeholder='Reply' id='reply_id".$id."'>
                                                <button class='btn btn-primary ajax_reply_button' type='button' data-post-id='".$id."' data-id='id".$id."'  data-comment-id='".$id."'>
                                                    <i class='far fa-edit text-light'></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                               </div>
                           </div>
                       </div>";
            echo json_encode($txt);
        }
    }

    public static function actionShow()
    {
//        $orm = new ORM();
//        $allCommetns =  $orm
//            ->select('t_1.*, users.first_name AS reply_user_name, users.last_name AS reply_last_name')
//            ->from(function ($query) {
//                return $query->selectFrom('
//                        comments.*, comments.content AS comment_content,
//                        users.first_name,
//                        users.last_name,
//                        replyes.content AS replyes_content,
//                        replyes.user_id AS reply_user_id,
//                        replyes.created_at as reply_created_at')
//                    ->join('replyes', 'comments.id' , '=', 'replyes.comment_id')
//                    ->doubleJoin('users', 'comments.user_id' , '=', 'users.id')
//                    ->from('comments', 't_1');
//            })
//            ->join('users', 'users.id', '=', 't_1.reply_user_id')
//            ->get();

        $comment = new Comment();
        $join = $comment
            ->select('comments.*, users.id as user_id, users.first_name, users.last_name')
            ->join('users', 'users.id',  '=', 'comments.user_id')
            ->get();

        return $join;
    }
}