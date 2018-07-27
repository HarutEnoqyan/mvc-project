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
//        dd($_POST);
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
         <div class='border-bottom col-md-10'>
              <p><b>".Auth::getFullName()."</b></p>
                 ".$reply->attributes['content']."
         </div>
         <div class=\"border-bottom col-md-2 text-right\"><small>".$reply->attributes['created_at']."</small></div>
        ";
        echo $txt ;
    }

    public static function getReplyes($comment_id)
    {

    }

}