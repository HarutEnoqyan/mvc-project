<!DOCTYPE html>
<html>
	<head>
        <title>MVC-PROJECT</title>
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    </head>
	<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">MVC</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Posts <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link3</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#">Link2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="#">Link4</a>
                </li>
            </ul>

            <?php
            session_start();
            if ($_SESSION && $_SESSION['token']){?>
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
    </nav>