<div class="container mt-5">
    <form action="<?=route('post/save')?>" method="post">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" class="form-control" name="title" PLACEHOLDER="Title">
        </div>
        <div class="form-group">
            <label for="Content">Content</label>
            <textarea name="content" id="Content" cols="30" rows="3" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success btn-lg">Save</button>
    </form>
</div>