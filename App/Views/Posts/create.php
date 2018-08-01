<?php
if (session_id()=='') {
    session_start();

}

?>
<div class="container mt-5">
    <form action="<?=route('post/save')?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Upload Image</label>
            <div class="input-group">
            <span class="input-group-btn">
                <span class="btn btn-success btn-file">
                    Browse… <input type="file" id="imgInp" name="uploaded_file">
                </span>
            </span>
                <input  type="text" class="form-control" readonly>
            </div>
            <img id='img-upload'/>
        </div>
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