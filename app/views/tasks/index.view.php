<?php $layout = 'app/views/layouts/app.view.php' ?>

<form action="/tasks" method="POST">
    <div>
        <input type="text" name="username" placeholder="User name">
        <span><?= errors('username')->first() ; ?></span>
    </div>
    <div>
        <input type="email" name="email" placeholder="Email">
        <span><?= errors('email')->first() ; ?></span>        
    </div>
    <div>
        <textarea name="content" placeholder="Task content"></textarea>
        <span><?= errors('content')->first() ; ?></span>          
    </div>
    <button type="submit">Create task</button>
</form>

<h1>Tasks</h1>
<ul>
    <?php foreach($tasks as $task) : ?>
        <li>
            <span><?= htmlspecialchars($task->content); ?></span>
            <span><?= htmlspecialchars($task->username); ?></span>
            <span><?= htmlspecialchars($task->email); ?></span>

            <?php if (\App\Models\Auth::check()) : ?>
                <a href="#">Edit</a>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>

<?php (new Core\Session\ErrorsSessionStorage())->clear() ?>