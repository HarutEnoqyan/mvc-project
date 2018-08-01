<?php
if (session_id()=='') {
    session_start();
}
if (isset($params)) {
    $attr = $params;
}
?>
    <div class="container mt-5">

        <form action="<?=route('post/thumbnail_update' , ['id'=>$attr['id']])?>" method="post" enctype="multipart/form-data">
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
            <button type="submit" class="btn btn-success btn-lg">Save</button>
        </form>





    </div>
<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);