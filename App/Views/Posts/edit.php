<?php
$attr = $params;
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-2 font-weight-bold">
            Title :
        </div>
        <div class="col-md-10">
            <input type="text" class="form-control" value="<?= $attr['title'] ?>" >
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-2 font-weight-bold">
            Content :
        </div>
        <div class="col-md-10">
            <textarea class="form-control" style="resize: none"><?= $attr['content'] ?></textarea>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-2 font-weight-bold">
            Author :
        </div>
        <div class="col-md-10">
            <p> <?=$attr['first_name'] . " " . $attr['last_name'] ?> <span> At: <?=$attr['created_at']?> </span></p>
            <button class="btn btn-primary btn-lg"><a href="<?=route('post/update')?>" style="color: white;">Save</a></button>
        </div>
    </div>
</div>