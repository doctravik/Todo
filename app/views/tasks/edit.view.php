<?php $layout = 'app/views/layouts/app.view.php' ?>

<form action=<?="/tasks/{$task->id}/update";?> method="POST">
    <div>
        <input type="text" name="content" placeholder="Task content" 
            value="<?= htmlspecialchars(old('content', $task->content)) ; ?>">
        <span><?= errors('content')->first() ; ?></span>
    </div>
    <button type="submit">Update</button>
</form>
