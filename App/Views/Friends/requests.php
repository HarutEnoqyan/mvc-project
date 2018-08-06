
<h1 class="text-center">
    Requests List
</h1>
<div class="row">
    <?php
    if (!is_array($params)) {
        echo"<p class = 'text-danger ' >".$params." </p>";
        die;
    }
    foreach ($params as $param) {
        $user = $param;
        $avatar = $user['avatar'];
        $name = $user['name'];

        if (is_array($param)) {


        ?>

        <div class="col-sm-3">
            <div class="card">
                <canvas class="header-bg" width="250" height="70" id="header-blur"></canvas>
                <img class="src-image" src = '<?=$avatar===null?'images/default-profile.jpg':'images/uploads/'.$avatar?>' >

                <div class="avatar">
                    <img src="" alt="" />
                </div>
                <div class="content">
                    <p><?= $name ?></p>
                    <p><button type="button" class="btn btn-default"><a href="<?=route('friend/accept',['id'=>$user['friend_id']])?>">Accept</a></button></p>
                    <p><button type="button" class="btn btn-default"><a href="<?=route('friend/decline',['id'=>$user['friend_id']])?>">Decline</a></button></p>
                </div>
            </div>
        </div>
    <?php } } ?>
</div>