<?php $layout = 'app/views/layouts/app.view.php' ?>

<form action="/admin/login" method="POST">
    <div>
        <input type="text" name="username" placeholder="Username">
        <span><?= errors('username')->first() ; ?></span>
    </div>
    <div>
        <input type="password" name="password" placeholder="Password">
        <span><?= errors('password')->first() ; ?></span>        
    </div>
    <button type="submit">Login</button>
</form>

<?php (new Core\Session\ErrorsSessionStorage())->clear() ?>