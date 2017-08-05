<?php $layout = 'app/views/layouts/app.view.php' ?>

<form action="/tasks" method="POST">
    <input type="text" name="username" placeholder="User name">
    <input type="email" name="email" placeholder="Email">
    <textarea name="content" placeholder="Task content"></textarea>
    <button type="submit">Create task</button>
</form>
<h1>Users</h1>
<a href="/users/create">Create new user</a>
<!-- 
<ul>
<?php foreach($users as $user) : ?>
    <li><?= htmlspecialchars($user->name); ?></li>
<?php endforeach; ?>
</ul> -->