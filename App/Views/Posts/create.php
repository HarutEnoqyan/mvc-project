<?php
if (session_id()=='') {
    session_start();

}

?>
<div class="container mt-5">
    <form action="<?=route('post/save')?>" method="post">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" value="<?= isset($_SESSION['old']['title'])===true ? $_SESSION['old']['title'] : '' ?>" class="form-control <?= isset($_SESSION['errors']['title'])===true ? 'is-invalid' : '' ?>" name="title" PLACEHOLDER="Title">
            <span class="text-danger"> <?= isset($_SESSION['errors']['title'])===true ? $_SESSION['errors']['title'] : '' ?></span>
        </div>
        <div class="form-group">
            <label for="Content">Content</label>
            <textarea name="content" id="Content" cols="30" rows="3" class="form-control <?= isset($_SESSION['errors']['content'])===true ? 'is-invalid' : ''?>"><?= isset($_SESSION['old']['content'])===true ? $_SESSION['old']['content'] : '' ?></textarea>
            <span class="text-danger"> <?= isset($_SESSION['errors']['content'])===true ? $_SESSION['errors']['content'] : '' ?></span>
        </div>
        <button type="submit" class="btn btn-success btn-lg">Save</button>
    </form>
</div>

<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);
?>