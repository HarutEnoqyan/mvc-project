<?php
//session_start();
if(!\Core\Auth::checkIfAuth()){
    redirect("/");
}
?>

<h1>Wellcome <?= $_SESSION['name'] ?></h1>

