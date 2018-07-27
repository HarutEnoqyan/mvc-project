<?php
?>
<div class="container mt-lg-2">
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
    <div class="row mb-5">
        <div class="col-md-11">
            <div class="row">
                <div class="col-md-12"><h2><?=$post['post_title'] ?></h2></div>
            </div>
            <div class="row  content_row">
                <div class="col-md-12 content">
                    <p><?=$post['post_content'] ?></p>
                </div>
                <div class="col-md-12">
                    <p class="p-0 mb-0"><small>Author : <?=$post['post_author']?>  </small></p>
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
        <div class="col-md-1 mt-5 pl-0 mb-5">
            <div class="col-md-12 pl-0">
                <button class="btn btn-success">
                    <a href="<?= route('post/show' , ['id'=>$post['post_id']])?>">
                        <i class="far fa-eye text-light"></i>
                    </a
                </button>
            </div>
            <?php
            if ($post['post_user_id']==\Core\Auth::getId()){
                ?>
                <div class="col-md-12 pl-0">
                    <button class="btn btn-success">
                        <a href="<?= route('post/edit',['id'=>$post['post_id']])?>">
                            <i class=" text-light fas fa-pencil-alt"></i>
                        </a>
                    </button>

                </div>
                <div class="col-md-12 pl-0">
                    <form class="form-inline" id="inlne-form" method="post" action="<?= route('post/delete',['id'=>$post['post_id']])?>" >
                        <button id="trash" type="submit" class="btn btn-danger">
                            <i class="far fa-trash-alt text-light"></i>
                        </button>
                    </form>
                </div>
                <?php
            }
            ?>

        </div>
        <div class="col-md-11">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#Collapse<?=$post['post_id']?>" aria-expanded="false" aria-controls="collapseExample">
                <?=$count." "?> <?=$count==1?'Comment' : 'Comments'?> <span class="comments-count"></span>
            </button>
            <div class="com-md-12 collapse" id="Collapse<?=$post['post_id']?>">
                <div class="card card-body">
                   <div class="all-post-comments" id="comment<?=$post['post_id']?>">
                       <div class="page-header col-md-12">
                           <div class="row border-bottom">
                               <div class="col-md-6 text-left">
                                   <h2>Comments</h2>
                               </div>
                               <div class="col-md-6 text-right">
                                   <small class=""><span class="comments-count"><?=$count?></span><?=$count==1?' Comment' : ' Comments'?></small>
                               </div>
                           </div>
                       </div>
                       <?php foreach ($post['comments'] as $comment) { ?>
                            <div class='comments-list border-bottom'>
                                <?php if ($count!=0){?>
                                    <div class='media'>
                                        <div class='media-body'>
                                            <h4 class='media-heading user_name'><?= $comment['comment_author']?></h4>
                                            <div class="comment_content">
                                                <?= $comment['comment_content']?>
                                                <div class=" replyes row border ml-3 mr-3" id="rep<?=$comment['comment_id']?>">
                                                    <?php foreach ($comment['replyes'] as $reply) { ?>
                                                        <div class="border-bottom col-md-10">
                                                            <p><b><?=$reply['reply_author']?></b></p>
                                                            <?=$reply['reply_content'] ?>
                                                        </div>
                                                        <div class="border-bottom col-md-2 text-right"><small><?=$reply['reply_created_at'] ?></small></div>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <small class='float-right'><?= $comment['comment_date']?></small>
                                            <div id="reply<?=$comment['comment_id']?>">
                                                <button class='btn btn-primary btn-sm' type='button' data-toggle='collapse' data-target='#CollapseReply<?=$comment['comment_id']?>' aria-expanded='false' aria-controls='collapseExample'>
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
                    <div class="mt-2 ml-2">
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
</div>

