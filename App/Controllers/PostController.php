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
                "posts.thumbnail as post_thumbnail",
                "CONCAT(post_user.first_name, ' ' , post_user.last_name) as post_author",
                "post_user.avatar as post_author_avatar",
                "CONCAT(comment_user.first_name, ' ' , comment_user.last_name) as comment_author",
                "comment_user.avatar as comment_author_avatar",
                "CONCAT(replyes_user.first_name, ' ' , replyes_user.last_name) as reply_author",
                "replyes_user.avatar as reply_author_avatar",
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


            $data = [];

            foreach ($posts as $post) {

                $comment_id = $post['comment_id'];
                $post_id    = $post['post_id'];


                if(array_key_exists($post_id , $data)) {
                    if(array_key_exists($comment_id , $data[$post_id]['comments'])) {
                        $data[$post_id]['comments'][$comment_id]['replyes'][] = [
                            'reply_content'     => $post['reply_content'],
                            'reply_author'      => $post['reply_author'],
                            'reply_created_at'  => $post['reply_created_at'],
                            'reply_author_avatar' => $post['reply_author_avatar']
                        ];

                        continue;
                    }

                    $data[$post_id]['comments'][$comment_id] = [
                        'comment_content' => $post['comment_content'],
                        'comment_author'  => $post['comment_author'],
                        'comment_author_avatar' => $post['comment_author_avatar'],
                        'comment_date'    => $post['comment_created_at'],
                        'comment_id'      => $post['comment_id'],
                        'replyes'         => !empty($post['reply_content']) ? [
                            [
                                'reply_content'     => $post['reply_content'],
                                'reply_author'      => $post['reply_author'],
                                'reply_created_at'  => $post['reply_created_at'],
                                'reply_author_avatar' => $post['reply_author_avatar']
                            ]
                        ] : []
                    ];

                    continue;
                }


                $data[$post_id] = [
                    'post_title'      => $post['post_title'],
                    'post_content'    => $post['post_content'],
                    'post_author'     => $post['post_author'],
                    'post_author_avatar' => $post['post_author_avatar'],
                    'post_user_id'    => $post['post_user_id'],
                    'post_created_at' => $post['post_created_at'],
                    'post_updated_at' => $post['post_updated_at'],
                    'post_thumbnail'  => $post['post_thumbnail'],
                    'post_id'         => $post['post_id'],
                    'comments' => [
                        $comment_id => [
                            'comment_content' => $post['comment_content'],
                            'comment_author'  => $post['comment_author'],
                            'comment_author_avatar' => $post['comment_author_avatar'],
                            'comment_date'    => $post['comment_created_at'],
                            'comment_id'      => $post['comment_id'],
                            'replyes'         => !empty($post['reply_content']) ? [[
                                'reply_content'     => $post['reply_content'],
                                'reply_author'      => $post['reply_author'],
                                'reply_author_avatar' => $post['reply_author_avatar'],
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

        function random_string($length) {
            $key = '';
            $keys = array_merge(range(0, 9), range('a', 'z'));

            for ($i = 0; $i < $length; $i++) {
                $key .= $keys[array_rand($keys)];
            }

            return $key;
        }


        $posts= new Post();
        $images = [];
//        var_dump($_FILES);die();
        if ($_FILES) {
            for ($i = 0 ; $i < count($_FILES['images']['type']); $i++) {
                $type = $_FILES['images']['type'][$i];
                $tempName = $_FILES['images']['tmp_name'][$i];
                if (isset($type)) {
                    if (!empty($type)) {
                        $fileName = random_string(20);
                        $location = 'images/uploads/';
                        $type = str_replace(substr($type,0,6), ".",$type);
                        move_uploaded_file($tempName , $location.$fileName.$type );
                        $images[]=$fileName.$type;
                    }
                }
            }
        }
//        dd($images);

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
            if (count($images)>0) {
                $posts->attributes['thumbnail'] = implode(',', $images);
            }
            $posts->insert();
            echo "true";
        } else {
            if (session_id()==''){
                session_start();
            }
            $_SESSION['old'] = $this->uncheckedData;
            $_SESSION['errors'] = $this->validateErrors;
            echo json_encode(['errors' => $this->validateErrors]);
//            redirect(route('post/create'));
        }


    }

    public function actionShow() {
        $id = $_GET['id'];
        $posts= new Post();

        $data = $posts
            ->select("posts.*, CONCAT(users.first_name,"."' "."'".",users.last_name) as user_name")
            ->join('users', 'users.id',  '=', "posts.user_id where posts.id=$id")
            ->first()->attributes;
        view("posts/show", $data );

    }

    public function actionDelete() {
        $id = $_GET['id'];
        $posts= new Post();
        $data = $posts
            ->select('thumbnail , user_id')
            ->where("id=$id")
            ->first()->attributes;
        $images = explode(',',$data['thumbnail']);
        foreach ($images as $image ) {
            if (file_exists(BASE_PATH.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$image)) {
                unlink(BASE_PATH.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$image);
            }
        }
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


    public function actionThumbnail_edit ()
    {
        $id = $_GET['id'];
        $posts = new Post();

        $data = $posts
            ->select('posts.*, users.id as user_id, CONCAT(users.first_name, " " ,users.last_name) as user_name')
            ->join('users', 'users.id',  '=', 'posts.user_id')
            ->where("posts.id = $id")
            ->first()->attributes;

        if($data['user_id']==Auth::getId()){
            view("Posts/thumbnail_edit", $data );
        }else {
            redirect(route('post/index'));
        }
    }

    public function actionThumbnail_update()
    {
        $id = $_POST['id'];
        $posts= new Post();

        function random_string($length) {
            $key = '';
            $keys = array_merge(range(0, 9), range('a', 'z'));

            for ($i = 0; $i < $length; $i++) {
                $key .= $keys[array_rand($keys)];
            }

            return $key;
        }

        $images = [];
        if (count($_FILES['images']['type'])>0) {
            for ($i = 0 ; $i < count($_FILES['images']['type']); $i++) {
                $type = $_FILES['images']['type'][$i];
                $tempName = $_FILES['images']['tmp_name'][$i];
                if (isset($type)) {
                    if (!empty($type)) {
                        $fileName = random_string(20);
                        $location = 'images/uploads/';
                        $type = str_replace(substr($type,0,6), ".",$type);
                        move_uploaded_file($tempName , $location.$fileName.$type );
                        $images[]=$fileName.$type;
                    }
                }
            }
        }

        if (count($images)>0) {
            $thumbnail = implode(',' , $images);
        } else {
            $thumbnail = '';
        }

        $oldFiles = explode(',' , $posts->where("id=$id")->select('thumbnail')->first()->attributes['thumbnail']);
        if (count($oldFiles) > 0) {
            foreach ($oldFiles as $oldFile) {
                if (file_exists(BASE_PATH.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$oldFile)) {
                    unlink(BASE_PATH.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$oldFile);
                }
            }
        }



        $posts->where("id=$id")
            ->set(['thumbnail'],[$thumbnail])
            ->update();
        echo "true";
    }

    public function actionTest()
    {
        dd(Validation::validateDate("2018.07-19 10:32:44"));
    }
}