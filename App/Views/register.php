<div class="">
    <h1 class="h3 mb-3 font-weight-normal text-center">Registration</h1>
    <form action="<?=route('user/create')?>" method="post" class="form-signin">
        <div class="form-group">
            <label for="first_name" >Name</label>
            <input name="first_name" id="first_name" type="text" class="form-control" placeholder="Name">
        </div>

        <div class="form-group">
            <label for="last_name" >Last Name</label>
            <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Last Name">
        </div>

        <div class="form-group">
            <label for="email" >Email</label>
            <input id="email" type="email" name="email" class="form-control" placeholder="Email">
        </div>

        <div class="form-group">
            <label for="age" >Dare Of Birth</label>
            <input id="age" type="date" name="age" class="form-control" placeholder="Date Of Birth">
        </div>

        <div class="form-group">
            <label for="password" >Password</label>
            <input id="password" type="password" name="password" class="form-control" placeholder="Password">
        </div>

        <button class="btn btn-block btn-lg btn-primary" type="submit">Login</button>
    </form>
</div>