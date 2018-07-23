<?php
?>
<div class="container mt-lg-2">
    <?php
    foreach ($params as $table=>$row) {
        $attr = $row->attributes
        ?>
        <div class="col-md-10 mb-5">
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
        <div class="col-md-2 mb-5">
            <div class="col-md-12">
                <button class="btn">
                    <a href="<?= route('post/show' , ['id'=>$attr['id']])?>">
                        <i class="far fa-eye"></i>
                    </a
                </button>
            </div>
            <?php
            if ($attr['user_id']==\Core\Auth::getId()){
                ?>
                <div class="col-md-12">
                    <a href="<?= route('post/edit',['id'=>$attr['id']])?>">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                </div>
                <div class="col-md-12">
                    <form class="form-inline" id="inlne-form" method="post" action="<?= route('post/delete',['id'=>$attr['id']])?>" >
                        <button id="trash" type="submit" class="btn btn-link">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
                <?php
            }
            ?>

        </div>
        <?php
    }
    ?>
</div>






