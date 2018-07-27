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

            $txt =
             "
                <div class='comments-list border-bottom'>
                        <div class='media'>
                            <div class='media-body'>
                                <h4 class='media-heading user_name'>".Auth::getFullName()."</h4>
                                <div class='comment_content'>
                                    ".$comment->attributes['content']." 
                                    <div class='replyes row border ml-3 mr-3' id="."'rep".$id."'".">
                                    </div>
                                </div>
                                <small class='float-right'>" . $comment->attributes['created_at'] . "</small>
                                <div id="."'reply".$id."'".">
                                    <button class='btn btn-primary btn-sm' type='button' data-toggle='collapse' data-target='".'#'."CollapseReply".$id."' aria-expanded='false' aria-controls='collapseExample'>
                                        <small>Reply</small>
                                    </button>
                                    <div class='com-md-12 collapse' id='CollapseReply".$id."'>
                                        <div class='form-group row mt-2'>
                                            <input name='comment_reply' type='text' class=' ml-3 ajax_reply_input form-control col-md-11' placeholder='Reply' id='reply_id".$id."' data-comment-id='".$id."'>
                                            <button class='btn btn-primary ajax_reply_button' type='button'  data-id='reply_id".$id."' data-comment-id='".$id."'>
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

    public static function actionShow()//41
    {
        $orm = new ORM();
//        $allCommetns =
//            ->select("t_2.*, CONCAT(users.first_name,' ',users.last_name) AS post_author")
//            ->from(function ($query) {
//               return $query->selectFrom('t_1.*, users.first_name AS reply_user_name, users.last_name AS reply_last_name, posts.*')
//                         ->from(function ($query) {
//                        return $query->selectFrom('
//                        comments.*, comments.content AS comment_content,
//                        users.first_name,
//                        users.last_name,
//                        replyes.content AS replyes_content,
//                        replyes.user_id AS reply_user_id,
//                        replyes.created_at as reply_created_at')
//                            ->join('replyes', 'comments.id' , '=', 'replyes.comment_id')
//                            ->doubleJoin('users', 'comments.user_id' , '=', 'users.id')
//                            ->from('comments', 't_1');
//                    })
//                    ->join('users', 'users.id', '=', 't_1.reply_user_id')
//                    ->doubleJoin('posts', 't_1.post_id', '=', 'posts.id');
//            })
//            ->join('users', 't_2.post_user_id' , '=', 'users.id')
//            ->from('replyes','t_2')
//            ->get();
//        $sql = 'SELECT t_2.*, CONCAT(users.first_name,'."'"." "."'".',users.last_name)AS post_author
//                FROM
//	            (
//                    SELECT
//                        t_1.*, CONCAT(
//                            users.first_name,
//                            '."'"." "."'".',
//                            users.last_name
//                        ) AS reply_author,
//                        posts.user_id AS post_user_id,
//                        posts.created_at AS post_created_at,
//                        posts.updated_at AS post_updated_at,
//                        posts.content AS post_content,
//                        posts.title AS post_title
//                    FROM
//                        (
//                            SELECT
//                                comments.*, comments.content AS comment_content,
//                                CONCAT(
//                                    users.first_name,
//                                   '."'"." "."'".',
//                                    users.last_name
//                                ) AS comment_author,
//                                replyes.content AS replyes_content,
//                                replyes.user_id AS reply_user_id,
//                                replyes.created_at AS reply_created_at
//                            FROM
//                                comments
//                            LEFT JOIN replyes ON comments.id = replyes.comment_id
//                            LEFT JOIN users ON comments.user_id = users.id
//                        ) AS t_1
//                    LEFT JOIN users ON users.id = t_1.reply_user_id
//                    LEFT JOIN posts ON t_1.post_id = posts.id
//                ) AS t_2
//            LEFT JOIN users ON t_2.post_user_id = users.id';
//          $allPosts =  query($sql);
//
//
////        dd($allPosts);
//        $data = [];
//
//        foreach ($allPosts as $post) {
////            $comment    = $comment->attributes;
//            $comment_id = $post['id'];
//            $post_id    = $post['post_id'];
//
//
//            if(array_key_exists($post_id , $data)) {
//                if(array_key_exists($comment_id , $data[$post_id]['comments'])) {
//                    $data[$post_id]['comments'][$comment_id]['replies'][] = [
//                        'reply_content'     => $post['replyes_content'],
//                        'reply_author'      => $post['reply_author'],
//                        'reply_created_at'  => $post['reply_created_at']
//                    ];
//
//                    continue;
//                }
//
//                $data[$post_id]['comments'][$comment_id] = [
//                    'comment_content' => $post['comment_content'],
//                    'comment_author'  => $post['comment_author'],
//                    'comment_date'    => $post['created_at'],
//                    'comment_id'      => $post['id'],
//                    'coment_updated_at' => $post['updated_at'],
//                    'replies'         => !empty($post['replyes_content']) ? [
//                        [
//                            'reply_content'     => $post['replyes_content'],
//                            'reply_author'      => $post['reply_author'],
//                            'reply_created_at'  => $post['reply_created_at']
//                        ]
//                    ] : []
//                ];
//
//                continue;
//            }
//
//
//            $data[$post_id] = [
//                'post_title'      => $post['post_title'],
//                'post_content'    => $post['post_content'],
//                'post_author'     => $post['post_author'],
//                'post_user_id'    => $post['post_user_id'],
//                'post_created_at' => $post['post_created_at'],
//                'comments' => [
//                    $comment_id => [
//                        'comment_content' => $post['comment_content'],
//                        'comment_author'  => $post['comment_author'],
//                        'comment_date'    => $post['created_at'],
//                        'comment_id'      => $post['id'],
//                        'coment_updated_at' => $post['updated_at'],
//                        'replies'         => !empty($post['replyes_content']) ? [[
//                            'reply_content'     => $post['replyes_content'],
//                            'reply_author'      => $post['reply_author'],
//                            'reply_created_at'  => $post['reply_created_at']
//                        ]] : []
//                    ]
//                ]
//            ];


//            if(array_key_exists($comment_id , $data)) {
//                $data[$comment_id]['replies'][] = [
//                    'reply_content'     => $post['replyes_content'],
//                    'reply_author'      => $post['reply_author'],
//                    'reply_created_at'  => $post['reply_created_at']
//                ];
//                continue;
//            }
//
//            $data[$comment_id] = [
//                'comment_content' => $post['comment_content'],
//                'comment_author'  => $post['comment_author'],
//                'comment_date'    => $post['created_at'],
//                'comment_id'      => $post['id'],
//                'replies'         => !empty($post['replyes_content']) ? [[
//                    'reply_content'     => $post['replyes_content'],
//                    'reply_author'      => $post['reply_author'],
//                    'reply_created_at'  => $post['reply_created_at']
//                ]] : []
//            ];


        }
//        dd($data);
//        return $data;

}