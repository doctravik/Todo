<?php $layout = 'app/views/layouts/app.view.php' ?>

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <?php includePartial('layouts/partials/success.view.php') ; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Register new user</h3>
            </div>
            <div class="panel-body">
                <form action="/register" method="POST">
                    <div class="form-group <?= errors('username')->exists() ? 'has-error' : '' ; ?>">
                        <label for="username" class="control-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control"  
                            value="<?= htmlspecialchars(old('username')) ; ?>" autofocus>

                        <?php if(errors('username')->exists()) : ?>
                            <span class="help-block">
                                <strong><?= errors('username')->first() ; ?></strong>
                            </span>
                        <?php endif ; ?>
                    </div>

                    <div class="form-group <?= errors('email')->exists() ? 'has-error' : '' ; ?>">
                        <label for="email" class="control-label">Email</label>
                        <input type="text" id="email" name="email" class="form-control"  
                            value="<?= htmlspecialchars(old('email')) ; ?>" autofocus>

                        <?php if(errors('email')->exists()) : ?>
                            <span class="help-block">
                                <strong><?= errors('email')->first() ; ?></strong>
                            </span>
                        <?php endif ; ?>
                    </div>

                    <div class="form-group <?= errors('password')->exists() ? 'has-error' : '' ; ?>">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control"  
                            value="<?= htmlspecialchars(old('password')) ; ?>" autofocus>

                        <?php if(errors('password')->exists()) : ?>
                            <span class="help-block">
                                <strong><?= errors('password')->first() ; ?></strong>
                            </span>
                        <?php endif ; ?>
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>