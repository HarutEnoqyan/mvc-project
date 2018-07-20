<div class="container mt-lg-2">
        <a href="<?=route('post/create')?>" class="btn btn-success btn-sm" style="margin-bottom: 5px">
            <i class="fas fa-plus"></i>
            Add New
        </a>
        <table class="table table-condensed table-striped table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Creator</th>
                <th>Title</th>
                <th>Content</th>
                <th>Created_at</th>
                <th>Updated_at</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>

                <?php
                foreach ($params as $table=>$row) {
                    $attr = $row->attributes
                    ?>
                    <tr>
                    <td><?=$attr['id'] ?></td>
                    <td><?=$attr['first_name'] ." " . $attr['last_name'] ?></td>
                    <td><?=$attr['title'] ?></td>
                    <td><?=$attr['content'] ?></td>
                    <td><?=$attr['created_at'] ?></td>
                    <td><?=$attr['updated_at'] ?></td>
                    <td>
                        <a href="#">
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="#">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form class="form-inline" id="inlne-form" method="post" action="#" >
                            <button id="trash" type="submit" class="btn btn-link">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
            </tr>
                    <?php
                }
                ?>

            </tbody>

            <tfoot>
            <tr>
                <th>ID</th>
                <th>Creator</th>
                <th>Title</th>
                <th>Content</th>
                <th>Created_at</th>
                <th>Updated_at</th>
                <th>Actions</th>
            </tr>
            </tfoot>
        </table>
</div>
