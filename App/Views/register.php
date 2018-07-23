<?php
if (session_id()=='') {
    session_start();
};
    ?>

<div class="">
    <h1 class="h3 mb-3 font-weight-normal text-center">Registration</h1>
    <form action="<?=route('user/create')?>" method="post" class="form-signin">
        <div class="form-group">
            <label for="first_name" >Name</label>
            <input name="first_name" id="first_name" type="text" value="<?=isset($_SESSION['old']['name'])=== true ?  $_SESSION['old']['name']  : ''?>" class="form-control <?=isset($_SESSION['errors']['name'])=== true ?  'is-invalid'  : ''?> " placeholder="Name">
            <span class="text-danger"><?=isset($_SESSION['errors']['name'])=== true ? $_SESSION['errors']['name'] : ''?></span>
        </div>

        <div class="form-group">
            <label for="last_name" >Last Name</label>
            <input id="last_name" name="last_name" type="text" value="<?=isset($_SESSION['old']['last_name'])=== true ?  $_SESSION['old']['last_name']  : ''?>" class="form-control <?=isset($_SESSION['errors']['last_name'])=== true ?  'is-invalid'  : ''?>" placeholder="Last Name">
            <span class="text-danger"><?=isset($_SESSION['errors']['last_name'])=== true ? $_SESSION['errors']['last_name'] : ''?></span>
        </div>

        <div class="form-group">
            <label for="email" >Email</label>
            <input id="email" type="email" name="email" value="<?=isset($_SESSION['old']['email'])=== true ?  $_SESSION['old']['email']  : ''?>"  class="form-control <?=isset($_SESSION['errors']['email'])=== true ?  'is-invalid'  : ''?>" placeholder="Email">
            <span class="text-danger"><?=isset($_SESSION['errors']['email'])=== true ? $_SESSION['errors']['email'] : ''?></span>
        </div>

        <div class="form-group">
            <label for="age" >Dare Of Birth</label>
            <input id="age" type="date" name="age" value="<?=isset($_SESSION['old']['age'])=== true ?  $_SESSION['old']['age']  : ''?>"  class="form-control <?=isset($_SESSION['errors']['age'])=== true ?  'is-invalid'  : ''?>" placeholder="Date Of Birth">
            <span class="text-danger"><?=isset($_SESSION['errors']['age'])=== true ? $_SESSION['errors']['age'] : ''?></span>
        </div>

        <div class="form-group">
            <label for="password" >Password</label>
            <input id="password" type="password" name="password" value="<?=isset($_SESSION['old']['password'])=== true ?  $_SESSION['old']['password']  : ''?>"  class="form-control <?=isset($_SESSION['errors']['password'])=== true ?  'is-invalid'  : ''?>" placeholder="Password">
            <span class="text-danger"><?=isset($_SESSION['errors']['password'])=== true ? $_SESSION['errors']['password'] : ''?></span>
        </div>

        <button class="btn btn-block btn-lg btn-primary" type="submit">Register</button>
    </form>
</div>

<?php unset($_SESSION['errors']);
unset($_SESSION['old']);