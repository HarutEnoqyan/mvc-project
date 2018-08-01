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
        $avatar = NULL;
        if (isset($_SESSION['avatar'])) {
            $avatar = $_SESSION['avatar'];
        }
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

            $txt =
             "
                <div class='comments-list border m-2'>
                        <div class='media'>
                            <div class='media-body'>
                                 <div>
                                    <img src="."'".($avatar===NULL ? 'images/default-profile.jpg' : 'images/uploads/'.$avatar)."'"."  alt='default-profile' class=' comment-author-pic'>
                                    <h6 class='media-heading user_name'>".Auth::getFullName()."</h6>
                                 </div>
                                 <small class='float-right'>" . $comment->attributes['created_at'] . "</small>

                                <div class='comment_content'>
                                    ".$comment->attributes['content']." 
                                    <div class='replyes row ml-3 mr-3' id="."'rep".$id."'".">
                                    </div>
                                </div>
                                <div id="."'reply".$id."'"." class='col-md-10'>
                                    <button class='btn btn-primary btn-sm' type='button' data-toggle='collapse' data-target='".'#'."CollapseReply".$id."' aria-expanded='false' aria-controls='collapseExample'>
                                        <small>Reply</small>
                                    </button>
                                    <div class='com-md-12 collapse' id='CollapseReply".$id."'>
                                        <div class='form-group row mt-2'>
                                            <input name='comment_reply' type='text' class=' ml-3 ajax_reply_input form-control col-md-11' placeholder='Reply' id='reply_id".$id."' data-comment-id='".$id."'>
                                            <button class='btn ml-1 btn-primary ajax_reply_button' type='button'  data-id='reply_id".$id."' data-comment-id='".$id."'>
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

    }

}