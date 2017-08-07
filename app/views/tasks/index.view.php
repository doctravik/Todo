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
            <?php if (\App\Models\Auth::check()) : ?>
                <form action=<?="/tasks/{$task->id}/status/update";?> method="POST">
                    <input type="checkbox" name="is_completed"
                        onChange="this.form.submit()" <?= $task->is_completed ? 'checked' : ''; ?> >
                </form>
            <?php endif; ?>
            <span><?= htmlspecialchars($task->content); ?></span>
            <span><?= htmlspecialchars($task->username); ?></span>
            <span><?= htmlspecialchars($task->email); ?></span>

            <?php if ($task->is_completed) : ?>
                <b>Completed</b>
            <?php endif; ?>

            <?php if (\App\Models\Auth::check()) : ?>
                <a href=<?="/tasks/{$task->id}/edit"; ?>>Edit</a>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>

<?php (new Core\Session\ErrorsSessionStorage())->clear() ?>