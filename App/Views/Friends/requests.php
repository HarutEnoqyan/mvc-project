
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
                <div class="modal fade" id="myModal<?=$user['friend_id']?>" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><?= $name ?></h4>
                                <!--                            <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                            </div>
                            <div class="modal-body">
                                <div class="row profile">
                                    <div class="col-md-12">
                                        <div class="profile-sidebar text-center">
                                            <!-- SIDEBAR USERPIC -->
                                            <div class="profile-userpic">
                                                <img src="<?=$avatar===null || $avatar==""?'images/default-profile.jpg':'images/uploads/'.$avatar?>" class="img-responsive" alt="">
                                            </div>
                                            <!-- END SIDEBAR USERPIC -->
                                            <!-- SIDEBAR USER TITLE -->
                                            <div class="profile-usertitle">
                                                <div class="profile-usertitle-name">
                                                    <?= $name ?>
                                                </div>
                                                <div class="profile-usertitle-job">
                                                    Developer
                                                </div>
                                            </div>
                                            <!-- END SIDEBAR USER TITLE -->
                                            <!-- SIDEBAR BUTTONS -->
                                            <div class="profile-userbuttons">
                                                <button type="button" class="btn btn-default"><a href="<?=route('friend/accept',['id'=>$user['friend_id']])?>">Accept</a></button>
                                                <button type="button" class="btn btn-default"><a href="<?=route('friend/decline',['id'=>$user['friend_id']])?>">Decline</a></button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="collapse" data-target="#collaps<?=$user['friend_id']?>" aria-expanded="false" aria-controls="collapseExample">
                                                    Message
                                                </button>
                                                <div class="collapse mt-2 p-0 message-input" id="collaps<?=$user['friend_id']?>">
                                                    <div class="col-md-8" style="display: inline-block">
                                                        <input type="text" data-id="<?=$user['friend_id']?>" id="content" class="form-control" placeholder="Enter message" name="message_text">
                                                    </div>
                                                    <div class="col-md-1 p-0" style="display: inline-block">
                                                        <input type="button" data-id="<?=$user['friend_id']?>" class="btn btn-primary send_message " value="Send" >
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END SIDEBAR BUTTONS -->
                                            <!-- SIDEBAR MENU -->
                                            <div class="profile-usermenu">
                                                <ul class="nav">
                                                    <li class="active">
                                                        <a href="#">
                                                            <i class="glyphicon glyphicon-home"></i>
                                                            Overview </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- END MENU -->
                                        </div>
                                    </div>
                                    <!--                                <div class="col-md-9">-->
                                    <!--                                    <div class="profile-content">-->
                                    <!--                                        Some user related content goes here...-->
                                    <!--                                    </div>-->
                                    <!--                                </div>-->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="avatar">
                    <img data-toggle="modal" data-target="#myModal<?=$user['friend_id']?>" src="" alt="" />
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