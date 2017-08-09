<?php $layout = 'app/views/layouts/app.view.php' ?>

<?php isset($_SESSION['errors']) ? var_dump($_SESSION['errors']) : ''; ?>

<?php includePartial("tasks/create.view.php") ; ?>

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

            <?php includePartial("images/upload.view.php", compact('task')) ; ?>
        </li>
    <?php endforeach; ?>
</ul>

<?php includePartial("pagination/template.view.php", ['paginator' => $tasks]) ; ?>