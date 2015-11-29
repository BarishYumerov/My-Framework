<?php /** @model = RegisterBindingModel */?>
<div class="col-lg-12 login">
    <h2 class="col-lg-offset-4">Register:</h2>
    <form method="post" action="/account/register" class="col-lg-3 col-lg-offset-4">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control"/>
        </div>

        <div class="form-group">
            <label for="password">Password: </label>
            <input type="password" id="password" name="password" class="form-control" />
        </div>

        <div class="form-group">
            <label for="confirm">Confirm Password: </label>
            <input type="password" id="confirm" name="confirm" class="form-control" />
        </div>

        <div class="form-group">
            <label for="email">Email: </label>
            <input type="email" id="email" name="email" class="form-control" />
        </div>

        <div class="form-group">
            <label for="telephone">Phone Number: </label>
            <input type="text" id="telephone" name="telephone" class="form-control" />
        </div>

        <input type="submit" class="btn btn-default" value="Register" />

        <?php echo $this->getCsfrToken() ?>
    </form>
</div>
