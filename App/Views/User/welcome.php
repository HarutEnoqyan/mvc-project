<?php
//session_start();
if(!$_SESSION['token']){
    redirect("/");
}
?>

<h1>Wellcome <?= $_GET['name'] ?></h1>

