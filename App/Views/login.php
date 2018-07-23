<?php
if (session_id()=='') {
    session_start();
};
?>
<div class="">
    <h1 class="h3 mb-3 font-weight-normal text-center">Log in</h1>
    <p class="text-danger text-center"><?= isset($_SESSION['login_error'])=== true ? $_SESSION['login_error'] : ''; ?></p>
    <form action="<?=route('user/check')?>" method="post" class="form-signin">

        <div class="form-group">
            <label for="email" >Email</label>
            <input id="email" type="email" name="email" value="<?=isset($_SESSION['old']['email'])=== true ?  $_SESSION['old']['email']  : ''?>"  class="form-control <?=isset($_SESSION['errors']['email'])=== true ?  'is-invalid'  : ''?>" placeholder="Email">
            <span class="text-danger"><?=isset($_SESSION['errors']['email'])=== true ? $_SESSION['errors']['email'] : ''?></span>
        </div>

        <div class="form-group">
            <label for="password" >Password</label>
            <input id="password" type="password" name="password" value="<?=isset($_SESSION['old']['password'])=== true ?  $_SESSION['old']['password']  : ''?>"  class="form-control <?=isset($_SESSION['errors']['password'])=== true ?  'is-invalid'  : ''?>" placeholder="Password">
            <span class="text-danger"><?=isset($_SESSION['errors']['password'])=== true ? $_SESSION['errors']['password'] : ''?></span>
        </div>

        <label for="checkbox">
            <input id="checkbox" name="rememberTocken" type="checkbox" class="form-controlo" value="true">
            Remember me
        </label>


        <button class="btn btn-block btn-lg btn-primary" type="submit">Login</button>
    </form>
</div>
<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);
unset($_SESSION['login_error']);
