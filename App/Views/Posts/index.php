<?php
?>
<div class="container mt-lg-2">
    <?php
    foreach ($params as $table=>$row) {
        $attr = $row->attributes
        ?>
    <div class="row mb-5">
        <div class="col-md-11">
            <div class="row">
                <div class="col-md-12"><h2><?=$attr['title'] ?></h2></div>
            </div>
            <div class="row  content_row">
                <div class="col-md-12 content">
                    <p><?=$attr['content'] ?></p>
                </div>
                <div class="col-md-12">
                    <p class="p-0 mb-0"><small>Author : <?=$attr['first_name'] ." " . $attr['last_name'] ?>  </small></p>
                    <p class="p-0 mb-0"><small>Created at: <?=$attr['created_at'] ?></small></p>
                    <?php
                    if (isset($attr['updated_at'])){
                        ?>
                        <p class="p-0"><small>Updated at: <?=$attr['updated_at'] ?></small></p>

                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-1 mt-5 pl-0 mb-5">
            <div class="col-md-12 pl-0">
                <button class="btn btn-success">
                    <a href="<?= route('post/show' , ['id'=>$attr['id']])?>">
                        <i class="far fa-eye text-light"></i>
                    </a
                </button>
            </div>
            <?php
            if ($attr['user_id']==\Core\Auth::getId()){
                ?>
                <div class="col-md-12 pl-0">
                    <button class="btn btn-success">
                        <a href="<?= route('post/edit',['id'=>$attr['id']])?>">
                            <i class=" text-light fas fa-pencil-alt"></i>
                        </a>
                    </button>

                </div>
                <div class="col-md-12 pl-0">
                    <form class="form-inline" id="inlne-form" method="post" action="<?= route('post/delete',['id'=>$attr['id']])?>" >
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
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#Collapse<?=$attr['created_at'] ?>" aria-expanded="false" aria-controls="collapseExample">
                Comments <span class="comments-count"></span>
            </button>
            <div class="com-md-12 collapse" id="Collapse<?=$attr['created_at'] ?>">
                <div class="card card-body">
                    <div class="page-header col-md-12">
                        <div class="row border-bottom">
                            <div class="col-md-6 text-left">
                                <h2>Comments</h2>
                            </div>
                            <div class="col-md-6 text-right">
                                <small class=""><span class="comments-count">15</span> comments</small>
                            </div>
                        </div>
                    </div>
                    <div class="comments-list border-bottom">
                        <div class="media">
                            <a class="media-left" href="#">
                                <!--                                <img src="http://lorempixel.com/40/40/people/1/">-->
                            </a>
                            <div class="media-body">

                                <h4 class="media-heading user_name">Baltej Singh </h4>
                                Wow! this is really great.
                                <small class="float-right">5 days ago</small>
                                <p><small><a href="">Reply</a></small></p>
                            </div>
                        </div>
                    </div>
                    <div class="comments-list border-bottom">
                        <div class="media">
                            <a class="media-left" href="#">
                                <!--                                <img src="http://lorempixel.com/40/40/people/1/">-->
                            </a>
                            <div class="media-body">

                                <h4 class="media-heading user_name">Baltej Singh </h4>
                                Wow! this is really great.
                                <small class="float-right">5 days ago</small>
                                <p><small><a href="">Reply</a></small></p>
                            </div>
                        </div>
                    </div>
                    <form action="#" method="post" class="mt-2 ml-2">
                        <div class="form-group row">
                            <input type="text" class="form-control col-md-11" placeholder="Write a comment">
                            <button class="btn btn-primary" type="submit">
                                <i class="far fa-edit text-light"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <?php
    }
    ?>
</div>






