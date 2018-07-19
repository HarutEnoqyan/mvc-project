
<div class="">
    <h1 class="h3 mb-3 font-weight-normal text-center">Log in</h1>
    <form action="<?=route('user/check')?>" method="post" class="form-signin">

        <div class="form-group">
            <label for="email" >Email</label>
            <input id="email" type="email" name="email" class="form-control" placeholder="Email">
        </div>

        <div class="form-group">
            <label for="password" >Password</label>
            <input id="password" type="password" name="password" class="form-control" placeholder="Password">
        </div>

        <label for="checkbox">
            <input id="checkbox" name="rememberTocken" type="checkbox" class="form-controlo" value="true">
            Remember me
        </label>


        <button class="btn btn-block btn-lg btn-primary" type="submit">Login</button>
    </form>
</div>