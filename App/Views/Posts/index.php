<button class="btn btn-success text-light">
    <a class="text-light" href="<?=route('post/create')?>">
        <i class="fas fa-plus"></i>
        Add new Post
    </a>
</button>
    <?php

    /** @var ArrayAccess $params */
//    dd($params);
    foreach ($params as $post) {
        $count = 0;
        foreach ($post['comments'] as $comment){
            if ($comment['comment_content']===NULL){
                $comment=[];
            }else {
                $count++;
            }
        }




        //        dd($post);
        ?>
    <div class="post border-bottom mb-5 mt-2 pb-2 pt-3" id="post_<?=$post['post_id']?>">
        <div class="row relative">
            <div class="post-navbar absolute">
                <div class="btn-group dropleft">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-ellipsis-v"></i></button>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <button class=" btn dropdown-item" type="button">
                            <a class="text-dark" href="<?= route('post/show' , ['id'=>$post['post_id']])?>">
                                Show
                            </a
                        </button>
                        <?php
                        if ($post['post_user_id']==\Core\Auth::getId()){
                            ?>
                            <button class=" btn dropdown-item" type="button">
                                <a class="text-dark" href="<?= route('post/edit',['id'=>$post['post_id']])?>">
                                    Update
                                </a>
                            </button>
                            <form class="form-inline" id="inlne-form" method="post" action="<?= route('post/delete',['id'=>$post['post_id']])?>" >
                                <button class=" btn dropdown-item" type="button">
                                    Delete
                                </button>
                            </form>

                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12"><h2><?=$post['post_title'] ?></h2></div>
                <img class="ml-2" src="images/blog-default.png" alt="blog-default">
            </div>
            <div class="row m-0 mb-2 mt-2 blog-content content_row">
                <div class="col-md-12 content">
                    <p><?=$post['post_content'] ?></p>
                </div>
                <div class="col-md-12">
                    <div class="p-0 mb-0">Author : <img class="profile-pic" src="images/default-profile.jpg" alt="profile-edfault">  <?=$post['post_author']?> </div>
                    <p class="p-0 mb-0"><small>Created at: <?=$post['post_created_at'] ?></small></p>
                    <?php
                    if (isset($post['post_updated_at'])){
                        ?>
                        <p class="p-0"><small>Updated at: <?=$post['post_updated_at'] ?></small></p>

                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#Collapse<?=$post['post_id']?>" aria-expanded="false" aria-controls="collapseExample">
                <?=$count." "?> <?=$count==1?'Comment' : 'Comments'?> <span class="comments-count"></span>
            </button>
            <div class=" ml-4 mt-2 col-md-12 collapse" id="Collapse<?=$post['post_id']?>">
                <div class="all-post-comments" id="comment<?=$post['post_id']?>">
                    <?php foreach ($post['comments'] as $comment) { ?>
                        <div class='comments-list border m-2'>
                            <?php if ($count!=0){?>
                                <div class='media'>
                                    <div class='media-body'>
                                        <div>
                                            <img src="images/default-profile.jpg"  alt="default-profile" class="comment-author-pic">
                                            <h6 class='media-heading user_name'><?= $comment['comment_author']?></h6>
                                        </div>
                                        <small class='float-right'><?= $comment['comment_date']?></small>
                                        <div class="comment_content">
                                            <?= $comment['comment_content']?>
                                            <div class="replyes row ml-3 mr-3" id="rep<?=$comment['comment_id']?>">
                                                <?php foreach ($comment['replyes'] as $reply) { ?>
                                                    <div class="border pt-2 reply-content mt-2 col-md-11">
                                                        <p><img src="images/default-profile.jpg"  alt="default-profile" class="reply-author-pic mr-2"> <?=$reply['reply_author']?></p>
                                                        <?=$reply['reply_content'] ?>
                                                        <small class="float-right"><?=$reply['reply_created_at'] ?></small>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div id="reply<?=$comment['comment_id']?>" class="col-md-10">
                                            <button class='mt-2 btn btn-primary btn-sm' type='button' data-toggle='collapse' data-target='#CollapseReply<?=$comment['comment_id']?>' aria-expanded='false' aria-controls='collapseExample'>
                                                <small>Reply</small>
                                            </button>
                                            <div class='com-md-12 collapse' id='CollapseReply<?=$comment['comment_id']?>'>
                                                <div class='form-group row mt-2'>
                                                    <input name='comment_reply' type='text' class=' ml-3 ajax_reply_input form-control col-md-11' placeholder='Reply' data-comment-id='<?=$comment['comment_id']?>' id='reply_id<?=$comment['comment_id']?>' >
                                                    <button class='btn btn-primary ajax_reply_button' type='button'  data-id='reply_id<?=$comment['comment_id']?>' data-comment-id='<?=$comment['comment_id']?>'>
                                                        <i class='far fa-edit text-light'></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="mt-2 ml-4">
                    <div class="form-group row">
                        <input name="comment" type="text" class="ajax_input form-control col-md-11" placeholder="Write a comment" id="id<?=$post['post_id']?>" data-post-id="<?=$post['post_id']?>">
                        <button class="btn btn-primary ajax_button" type="button" data-post-id="<?=$post['post_id']?>" data-id="id<?=$post['post_id']?>">
                            <i class="far fa-edit text-light"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
        <?php


    }

    ?>

