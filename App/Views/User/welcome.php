<?php
//session_start();
if(!\Core\Auth::checkIfAuth()){
    redirect("/");
}
$avatar=null;
if (isset($_SESSION['avatar'])){
    $avatar = $_SESSION['avatar'];
}

?>



<h1><img id="welcome-profile-pic" src="<?=$avatar===null?'/images/default-profile.jpg':'/images/uploads/'.$avatar?>" alt=""> Wellcome <?= $_SESSION['name'] ?></h1>

