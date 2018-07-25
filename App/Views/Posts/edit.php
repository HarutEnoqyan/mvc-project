<?php
if (session_id()=='') {
    session_start();
}
if (isset($params)) {
    $attr = $params;
}
?>
<div class="container mt-5">
    <form action="<?=route('post/update' , ['id'=>$attr['id']])?>" method="post">
        <div class="row">
            <div class="col-md-2 font-weight-bold form-group">
                <label for="title"> Title :</label>
            </div>
            <div class="col-md-10">
                <input name="title" id="title" type="text" class="form-control <?= isset($_SESSION['errors']['title'])===true ? 'is-invalid' : '' ?>" value="<?= isset($_SESSION['old']['title'])===true ? $_SESSION['old']['title'] : $attr['title'] ?>" >
                <span class="text-danger"> <?= isset($_SESSION['errors']['title'])===true ? $_SESSION['errors']['title'] : '' ?></span>

            </div>

        </div>

        <div class="row mt-3">
            <div class="col-md-2 font-weight-bold">
                <label for="content"> Content :</label>
            </div>
            <div class="col-md-10">
                <textarea name="content" id="content" class="form-control <?= isset($_SESSION['errors']['content'])===true ? 'is-invalid' : '' ?> " style="resize: none"><?= isset($_SESSION['old']['content'])===true ? $_SESSION['old']['content'] : $attr['content'] ?></textarea>
                <span class="text-danger"> <?= isset($_SESSION['errors']['content'])===true ? $_SESSION['errors']['content'] : '' ?></span>

            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-2 font-weight-bold">
                Author :
            </div>
            <div class="col-md-10">
                <p> <?=$attr['user_data']['first_name'] . " " . $attr['user_data']['last_name'] ?> <span> At: <?=$attr['created_at']?> </span></p>
                <button type="submit" class="btn btn-primary btn-lg">Save</button>
            </div>
        </div>
    </form>
</div>
<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);