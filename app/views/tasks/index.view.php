<?php $layout = 'app/views/layouts/app.view.php'; ?>

<div class="row">
    <div class="col-md-12">
        <?php includePartial("tasks/partials/errors.view.php") ; ?>
        <?php includePartial('layouts/partials/success.view.php') ; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Task list</h3>
            </div>
            <div class="panel-body">
                <?php if (count($tasks->getData())) : ?>
                    <table class="table">
                        <?php includePartial("tasks/partials/headers.view.php") ; ?>          
                        <tbody>
                            <?php foreach($tasks as $task) : ?>
                                <?php includePartial("tasks/partials/task.view.php", compact('task')) ; ?>
                            <?php endforeach ; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div><b>No tasks available</b></div>
                <?php endif ; ?>
            </div>
        </div>
        
        <?php includePartial("pagination/template.view.php", ['paginator' => $tasks]) ; ?>
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

        $("#file").change(function(){
            previewImage(this);
            $('#preview-image').show();
        });
    });

    $('#attachImageModal').on('hide.bs.modal', function (event) {
        $("#attach-form")[0].reset();
        $('#preview-image').attr('src', '');
        $('#preview-image').hide();
    });
</script>
