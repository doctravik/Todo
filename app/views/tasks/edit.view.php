<?php $layout = 'app/views/layouts/app.view.php' ?>


<form action=<?="/tasks/{$task->id}/update";?> method="POST">
    <div class="form-group <?= errors('content')->exists() ? 'has-error' : '' ;?>">
        <label for="content" class="control-label">Content</label>
        <textarea id="content" name="content" class="form-control" rows="5"><?=
            htmlspecialchars(old('content', $task->content)) ; 
        ?></textarea>

        <?php if(errors('content')->exists()) : ?>
            <span class="help-block">
                <strong><?= errors('content')->first() ; ?></strong>
            </span>
        <?php endif ; ?>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>
