<?php
$attr = $params;
?>
<div class="container mt-5">
    <form action="<?=route('post/update' , ['id'=>$attr['id']])?>" method="post">
        <div class="row">
            <div class="col-md-2 font-weight-bold form-group">
                <label for="title"> Title :</label>
            </div>
            <div class="col-md-10">
                <input name="title" id="title" type="text" class="form-control" value="<?= $attr['title'] ?>" >
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-2 font-weight-bold">
                <label for="content"> Content :</label>
            </div>
            <div class="col-md-10">
                <textarea name="content" id="content" class="form-control" style="resize: none"><?= $attr['content'] ?></textarea>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-2 font-weight-bold">
                Author :
            </div>
            <div class="col-md-10">
                <p> <?=$attr['first_name'] . " " . $attr['last_name'] ?> <span> At: <?=$attr['created_at']?> </span></p>
                <button type="submit" class="btn btn-primary btn-lg">Save</button>
            </div>
        </div>
    </form>
</div>