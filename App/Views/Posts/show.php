<?php
if(isset($params)){
    $post = $params;
}
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-2 font-weight-bold">
            Title :
        </div>
        <div class="col-md-10">
            <input type="text" class="form-control" value="<?= $post['title'] ?>" disabled>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-2 font-weight-bold">
            Content :
        </div>
        <div class="col-md-10">
            <textarea class="form-control"  disabled style="resize: none"><?= $post['content'] ?></textarea>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-2 font-weight-bold">
            Author :
        </div>
        <div class="col-md-10">
            <p> <?=$post['user_name']?> <span> At: <?=$post['created_at']?> </span></p>
            <button class="btn btn-primary btn-lg"><a href="<?=route('post/index')?>" style="color: white;">Back</a></button>
        </div>
    </div>
</div>