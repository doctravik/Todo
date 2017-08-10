<?php $layout = 'app/views/layouts/app.view.php' ?>

<?php isset($_SESSION['errors']) ? var_dump($_SESSION['errors']) : ''; ?>
<br>
<?php isset($_SESSION['old_input']) ? var_dump($_SESSION['old_input']) : ''; ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Task list</h3>
            </div>
            <div class="panel-body">
                <table class="table">
                    <?php includePartial("tasks/partials/headers.view.php") ; ?>
                    
                    <tbody>
                        <?php foreach($tasks as $task) : ?>
                            <?php includePartial("tasks/partials/task.view.php", compact('task')) ; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <?php includePartial("pagination/template.view.php", ['paginator' => $tasks]) ; ?>

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
    </div>
</div>

<?php includePartial("tasks/partials/edit-modal.view.php") ; ?>
<?php includePartial("tasks/partials/attach-image-modal.view.php") ; ?>

<script>
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var content = button.data('content');
        var id = button.data('id');

        var modal = $(this);
        modal.find('.modal-body form').attr('action', '/tasks/' + id + '/update');
        modal.find('.modal-body #content').val(content);
    });

    $('#attachImageModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');

        var modal = $(this);
        modal.find('.modal-body form').attr('action', '/tasks/' + id + '/image/upload');
        modal.find('#attachButton').on('click', function () {
            modal.find('.modal-body form').submit();
        });
    });
</script>
