<?php
namespace App\Controllers;
use App\Models\Replyes;
use Core\Validation;
use Core\Auth;

class ReplyesController {

    public $validateErrors = [];


    public function actionCreate()
    {
        $reply = new Replyes();
        $avatar=NULL;
        if (session_id()=='') {
            session_start();
        };

        if (isset($_SESSION['avatar'])) {
            $avatar = $_SESSION['avatar'];
        }
        if (Validation::validateComment($_POST['content'])===true){
           $reply->attributes['content']=$_POST['content'];
        } else {
            $this->validateErrors[]=Validation::validateComment($_POST['content']);
            return;
        }

        $reply->attributes['comment_id'] = $_POST['comment_id'];
        $reply->attributes["user_id"] = Auth::getId();
        $reply->attributes['created_at'] = date("Y-m-d H:i:s");
        $reply->insert();
        $txt = "
         <div class='border pt-2 reply-content mt-2 col-md-11'>
            <p><img src="."'".($avatar===NULL ? 'images/default-profile.jpg' : 'images/uploads/'.$avatar)."'"."   alt='default-profile' class='reply-author-pic mr-2'> ".Auth::getFullName()."</p>
           
                ".$reply->attributes['content']."
                <small class='float-right'>".$reply->attributes['created_at']."</small>
         </div>
        ";
        echo $txt ;
    }

    public static function getReplyes($comment_id)
    {

    }

}