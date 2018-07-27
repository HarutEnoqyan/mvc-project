<?php
namespace App\Controllers;
use App\Models\Post;
use Core\Auth;
use Core\Validation;


class PostController {
    protected $validateErrors = [];
    protected $uncheckedData = [];

    /**
     *
     */
    public function actionIndex()
    {
        if(Auth::checkIfAuth()){
            $post = new Post();

            $selects = [
                "posts.id as post_id",
                "posts.content as post_content",
                "posts.title as post_title",
                "posts.created_at as post_created_at",
                "posts.updated_at as post_updated_at",
                "posts.user_id as post_user_id",
                "CONCAT(post_user.first_name, ' ' , post_user.last_name) as post_author",
                "CONCAT(comment_user.first_name, ' ' , comment_user.last_name) as comment_author",
                "CONCAT(replyes_user.first_name, ' ' , replyes_user.last_name) as reply_author",
                "comments.content as comment_content",
                "comments.created_at as comment_created_at",
                "comments.id as comment_id",
                "replyes.content as reply_content",
                "replyes.created_at as reply_created_at",
                "replyes.id as reply_id"
            ];

            $posts = $post->select(implode(',' , $selects))
                ->join('comments', 'posts.id', '=', 'comments.post_id')
                ->doubleJoin('replyes', 'comments.id', '=', 'replyes.comment_id')
                ->doubleJoin('users as post_user', 'posts.user_id', '=', 'post_user.id')
                ->doubleJoin('users as comment_user', 'comments.user_id', '=', 'comment_user.id')
                ->doubleJoin('users as replyes_user', 'replyes.user_id', '=', 'replyes_user.id')
                ->toArray();

//            dd($posts);


            $result = [];

//            foreach ($posts as $post) {
//                $post_id = $posts;
//            }


//        dd($allPosts);
            $data = [];

            foreach ($posts as $post) {
//            $comment    = $comment->attributes;
                $comment_id = $post['comment_id'];
                $post_id    = $post['post_id'];


                if(array_key_exists($post_id , $data)) {
                    if(array_key_exists($comment_id , $data[$post_id]['comments'])) {
                        $data[$post_id]['comments'][$comment_id]['replyes'][] = [
                            'reply_content'     => $post['reply_content'],
                            'reply_author'      => $post['reply_author'],
                            'reply_created_at'  => $post['reply_created_at']
                        ];

                        continue;
                    }

                    $data[$post_id]['comments'][$comment_id] = [
                        'comment_content' => $post['comment_content'],
                        'comment_author'  => $post['comment_author'],
                        'comment_date'    => $post['comment_created_at'],
                        'comment_id'      => $post['comment_id'],
                        'replyes'         => !empty($post['reply_content']) ? [
                            [
                                'reply_content'     => $post['reply_content'],
                                'reply_author'      => $post['reply_author'],
                                'reply_created_at'  => $post['reply_created_at']
                            ]
                        ] : []
                    ];

                    continue;
                }


                $data[$post_id] = [
                    'post_title'      => $post['post_title'],
                    'post_content'    => $post['post_content'],
                    'post_author'     => $post['post_author'],
                    'post_user_id'    => $post['post_user_id'],
                    'post_created_at' => $post['post_created_at'],
                    'post_updated_at' => $post['post_updated_at'],
                    'post_id'         => $post['post_id'],
                    'comments' => [
                        $comment_id => [
                            'comment_content' => $post['comment_content'],
                            'comment_author'  => $post['comment_author'],
                            'comment_date'    => $post['comment_created_at'],
                            'comment_id'      => $post['comment_id'],
                            'replyes'         => !empty($post['reply_content']) ? [[
                                'reply_content'     => $post['reply_content'],
                                'reply_author'      => $post['reply_author'],
                                'reply_created_at'  => $post['reply_created_at']
                            ]] : []
                        ]
                    ]
                ];

            }

            view("Posts/index", $data );
        } else{
            redirect(route('main/login'));
        }



    }

    public function actionCreate()
    {
        view('\\posts\\create');
    }

    public function actionSave() {
        $posts= new Post();

        $this->uncheckedData['title'] = $_REQUEST['title'];
        $this->uncheckedData['content'] = $_REQUEST['content'];

        if (Validation::validateTitle($_REQUEST['title'])=== true){
            $posts->attributes['title']=$_REQUEST['title'];
        }else{
           $this->validateErrors['title'] =Validation::validateTitle($_REQUEST['title']);
        }

        if (Validation::validateContent($_REQUEST['content'])===true){
            $posts->attributes['content']=$_REQUEST['content'];
        }else {
            $this->validateErrors['content'] = Validation::validateContent($_REQUEST['content']);
        }

        if (count($this->validateErrors)===0) {
            $posts->attributes['created_at']=date("Y-m-d H:i:s");
            $posts->attributes['user_id']=Auth::getId();
            $posts->insert();
            redirect(route('post/index'));
        } else {
            session_start();
            $_SESSION['old'] = $this->uncheckedData;
            $_SESSION['errors'] = $this->validateErrors;
            redirect(route('post/create'));
        }


    }

    public function actionShow() {
        $id = $_GET['id'];
        $posts= new Post();
        $post = $posts
            ->where("id = $id")
            ->first()->attributes;

        $data = $posts
            ->select('posts.*, users.id as user_id, users.first_name, users.last_name')
            ->join('users', 'users.id',  '=', 'posts.user_id')
            ->where("id = $id")
            ->first()->attributes;
        $post['user_data']=$data;




        view("Posts/show", $post );

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
        $posts = new Post();

        $post = $posts
            ->where("id = $id")
            ->first()->attributes;
        $data = $posts
            ->select('posts.*, users.id as user_id, users.first_name, users.last_name')
            ->join('users', 'users.id',  '=', 'posts.user_id')
            ->where("posts.id = $id")
            ->first()->attributes;

        $post['user_data']=$data;
        if($data['user_id']==Auth::getId()){
            view("Posts/edit", $post );
        }else {
            redirect(route('post/index'));
        }

    }

    public function actionUpdate() {
        $id = $_GET['id'];
        $posts= new Post();

        $this->uncheckedData['title'] = $_REQUEST['title'];
        $this->uncheckedData['content'] = $_REQUEST['content'];

        $title = '';
        if (Validation::validateTitle($_REQUEST['title'])=== true){
            $title=$_REQUEST['title'];
        }else{
            $this->validateErrors['title'] =Validation::validateTitle($_REQUEST['title']);
        }

        $content = '';
        if (Validation::validateContent($_REQUEST['content'])===true){
            $content=$_REQUEST['content'];
        }else {
            $this->validateErrors['content'] = Validation::validateContent($_REQUEST['content']);
        }

        if (count($this->validateErrors)===0) {
            $posts->where("id=$id")
                ->set(['title','content','updated_at'],[$title , $content, date("Y-m-d H:i:s")])
                ->update();
            redirect(route('post/index'));
        } else {
            session_start();
            $_SESSION['old'] = $this->uncheckedData;
            $_SESSION['errors'] = $this->validateErrors;
            redirect(route('post/edit' , ['id' => $id ]));
        }


    }

    public function actionTest()
    {
        dd(Validation::validateDate("2018.07-19 10:32:44"));
    }
}