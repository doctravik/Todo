<?php $layout = 'app/views/layouts/app.view.php' ?>

<form action="/tasks" method="POST">
    <input type="text" name="username" placeholder="User name">
    <input type="email" name="email" placeholder="Email">
    <textarea name="content" placeholder="Task content"></textarea>
    <button type="submit">Create task</button>
</form>

<h1>Tasks</h1>
<ul>
    <?php foreach($tasks as $task) : ?>
        <li>
            <span><?= htmlspecialchars($task->content); ?></span>
            <span><?= htmlspecialchars($task->username); ?></span>
            <span><?= htmlspecialchars($task->email); ?></span>
        </li>
    <?php endforeach; ?>
</ul>