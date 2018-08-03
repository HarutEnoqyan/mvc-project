<?php
if (session_id()=='') {
    session_start();

}

?>
<div class="container mt-5">
    <form action=""  enctype="multipart/form-data">
        <div class="form-group">
            <label for="inputId">Upload Image</label>
            <div class="input-group">
            <span class="input-group-btn">
                <span class="btn btn-success btn-file">
                    Browse… <input type="file" id="imgInp" name="uploaded_file[]" multiple>
                </span>
            </span>
                <input id="inputId" type="text" class="form-control" readonly>
            </div>
            <div class="upload-image-group row">
            </div>
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" class="form-control " name="title" PLACEHOLDER="Title">
            <span class="text-danger"> </span>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" cols="30" rows="3" class="form-control "></textarea>
            <span class="text-danger"> </span>
        </div>
        <button type="button" id="post-create-btn" class="btn btn-success btn-lg">Save</button>
    </form>
</div>

<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);
?>