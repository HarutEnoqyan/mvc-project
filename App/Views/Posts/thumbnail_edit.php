<?php
if (session_id()=='') {
    session_start();
}
if (isset($params)) {
    $attr = $params;
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

            <button type="button" data-id="<?=$attr['id']?>" id="post-edit-btn" class="btn btn-success btn-lg">Save</button>
        </form>
    </div>
<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);