<?php
use App\Models\User as User;
use App\Models\Message as Messages;
use Core\Auth;
$count = 0;
$messagesCount=0;
if (isset(User::initRequesters()['count'])){
    $count = User::initRequesters()['count'];
}
if(Auth::checkIfAuth()) {
    if(Messages::getNewMessages() ){
        $messagesCount = Messages::getNewMessages();
    }
}


if (session_id()=='') {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">MVC</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <?php
                if (\Core\Auth::checkIfAuth()) {
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?=route("post/index")?>">Posts <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="<?=route('user/show')?>">Users</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link " href="<?=route('friend/show')?>">MY Friends</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link relative" href="<?=route('friend/showRequests')?>">Friend Requests
                        <?php if (isset($count) && $count > 0){?>
                            <span class="requests-count absolute text-center" id="requests-count"><?= isset($count) ? $count : ''?></span>
                        <?php } ?>
                        </a>
                    </li>
                    <li class="nav-item relative" id="messangerLink">
                        <a href="<?=route('message/show')?>" class="nav-link">Messages</a>
                        <span class="requests-count absolute text-center" <?=$messagesCount>0?'style="display:block;"':'style="display:none;"'?> > <?=$messagesCount>0?$messagesCount:''?></span>
                    </li>
                <?php } ?>


            </ul>

            <?php
            if (\Core\Auth::checkIfAuth()){?>
                <a class="nav-link" href="<?=route("user/logout")?>">Logout</a>
            <?php }
            else{
                ?>
                <div class="form-inline my-2 my-lg-0">
                    <a class="nav-link" href="<?= route('main/login')?>">Login</a>
                    <a class="nav-link" href="<?= route('main/register')?>">Register</a>
                </div >
                <?php
            }
            ?>
        </div>
    </div>
</nav>