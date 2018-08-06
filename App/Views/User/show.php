<h1 class="text-center">
    User List
</h1>
<div class="row">
    <?php
    $friends = \App\Models\Friend::initFriendsId();
    $sentRequests = \App\Models\Friend::getSentRequests();
    $myRequests = \App\Models\Friend::initRequests();
    foreach ($params as $param) {
    $user = $param->attributes;
    $avatar = $user['avatar'];
    $name = $user['first_name'] . " " . $user['last_name'];


    ?>

    <div class="col-sm-3 mt-3">
        <div class="card">
            <canvas class="header-bg" width="250" height="70" id="header-blur"></canvas>
            <img class="src-image" src = '<?=$avatar===null?'images/default-profile.jpg':'images/uploads/'.$avatar?>' >

            <div class="avatar">
                <img src="" alt="" />
            </div>
            <div class="content">
                <p><?= $name ?></p>
                <p><button type="button" class="btn btn-default">
                        <?php
                            if (in_array($user['id'],$friends)){
                                echo 'Friends';
                            }
                            elseif (in_array($user['id'], $myRequests)){
                                ?>
                                <a href="<?=route('friend/accept',['id'=>$user['id']])?>">Accept</a>
                        <?php
                            }
                            elseif (in_array($user['id'], $sentRequests)) {
                                echo "Request sent";
                            }
                            else {
                                ?>
                                <a href="<?= route('friend/sendRequest', ['id' => $user['id']]) ?>">Send request</a>
                        <?php
                            }

                        ?>

                    </button>
                </p>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
