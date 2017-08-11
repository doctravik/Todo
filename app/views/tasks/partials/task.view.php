<tr>
    <?php if (auth()->check()) : ?>
        <td>
            <form action=<?="/tasks/{$task->id}/status/update";?> method="POST">
                <input type="checkbox" name="is_completed"
                    onChange="this.form.submit()" <?= $task->is_completed ? 'checked' : ''; ?> >
            </form>
        </td>
    <?php endif; ?>
    <td><?= htmlspecialchars($task->content); ?></div></td>
    <td><?= htmlspecialchars($task->username); ?></td>
    <td><?= htmlspecialchars($task->email); ?></td>
    <td>
        <?php if ($task->is_completed) : ?>
            <span class="label label-default">Completed</span>
        <?php endif; ?>
    </td>
    <td>
        <?php if ($task->image) : ?>
            <image src="<?= $task->image ;?>" class="img-responsive" alt="image" style="height: 50px">
        <?php endif ; ?>
    </td>
    <?php if (auth()->check()) : ?>
        <td>
            <a href="#" data-toggle="modal" data-target="#editModal" class="btn btn-default"
                data-id="<?= $task->id ;?>" 
                data-content="<?= htmlspecialchars($task->content) ;?>">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            </a>
            <a href="#" data-toggle="modal" data-target="#attachImageModal" class="btn btn-default"
                data-id="<?= $task->id ;?>" 
                data-content="<?= htmlspecialchars($task->content) ;?>">
                    <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
            </a>
        </td>
    <?php endif; ?>
</tr>