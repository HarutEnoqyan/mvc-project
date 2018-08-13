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
            <img class="src-image"  src = '<?=$avatar===null || $avatar==""?'/images/default-profile.jpg':'/images/uploads/'.$avatar?>' >
            <div class="modal fade" id="myModal<?=$user['id']?>" role="dialog">
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
                                            <img src="<?=$avatar===null || $avatar==""?'/images/default-profile.jpg':'/images/uploads/'.$avatar?>" class="img-responsive" alt="">
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
                                            <button type="button" class="btn btn-success btn-sm">
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
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="collapse" data-target="#collaps<?=$user['id']?>" aria-expanded="false" aria-controls="collapseExample">
                                                Message
                                            </button>
                                            <div class="collapse mt-2 p-0 message-input" id="collaps<?=$user['id']?>">
                                                <div class="col-md-8" style="display: inline-block">
                                                    <input data-id="<?=$user['id']?>" type="text" id="content" class="form-control" placeholder="Enter message" name="message_text">
                                                </div>
                                                <div class="col-md-1 p-0" style="display: inline-block">
                                                    <input type="button" data-id="<?=$user['id']?>" class="btn btn-primary send_message " value="Send" >
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
                <img data-toggle="modal" data-target="#myModal<?=$user['id']?>" src="" alt="" />
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
