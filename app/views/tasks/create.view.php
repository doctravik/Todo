<?php $layout = 'app/views/layouts/app.view.php' ?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Create new task</h3>
            </div>
            <div class="panel-body">
                <form action="/tasks" method="POST" class="form" enctype="multipart/form-data">
                    <div class="form-group <?= errors('user_id')->exists() ? 'has-error' : '' ; ?>">
                        <label for="form-userId" class="control-label">Username</label>
                        <select class="form-control" name="user_id" id="form-userId">
                            <option value="">Select user</option>
                            <?php foreach($users as $user) : ?>
                                <option value="<?= $user->id ; ?>"
                                    <?= (htmlspecialchars(old('user_id')) == $user->id) ? 'selected' : ''; ?>><?= htmlspecialchars($user->username) ; ?>
                                </option>
                            <?php endforeach ; ?>
                        </select>

                        <?php if(errors('user_id')->exists()) : ?>
                            <span class="help-block">
                                <strong><?= errors('user_id')->first() ; ?></strong>
                            </span>
                        <?php endif ; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="form-email" class="control-label">Email</label>
                        <input type="email" id="form-email" name="email" class="form-control" readonly>
                    </div>

                    <div class="form-group <?= errors('content')->exists() ? 'has-error' : '' ;?>">
                        <label for="form-content" class="control-label">Content</label>
                        <textarea id="form-content" name="content" class="form-control" rows="5"><?=
                            htmlspecialchars(old('content')) ; 
                        ?></textarea>

                        <?php if(errors('content')->exists()) : ?>
                            <span class="help-block">
                                <strong><?= errors('content')->first() ; ?></strong>
                            </span>
                        <?php endif ; ?>
                    </div>

                    <div class="form-group <?= errors('image')->exists() ? 'has-error' : '' ;?>">
                        <label for="form-file" class="control-label">Image</label>
                        <input type="file" id="form-file" name="image">

                        <?php if(errors('image')->exists()) : ?>
                            <span class="help-block">
                                <strong><?= errors('image')->first() ; ?></strong>
                            </span>
                        <?php endif ; ?>
                    </div>

                    <a href="#" data-toggle="modal" data-target="#previewCreateModal" class="btn btn-default"  role="button">Preview</a>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php includePartial("tasks/partials/preview-modal.view.php") ; ?>

<script>
    var users = <?php echo json_encode($users) ; ?>;

    $(document).ready(updateEmail);
    $('#form-userId').on('click', updateEmail);

    function updateEmail() {
        var user = users.filter(function(user) {
            return user.id == $('#form-userId').val();
        });

        var email = user[0] && user[0].email;
        $('#form-email').val(email); 
    }
    
    $('#previewCreateModal').on('show.bs.modal', function (event) {
        var modal = $(this);
        modal.find('.modal-body #content').text($('#form-content').val());
        modal.find('.modal-body #username').text($('#form-userId option:selected').text());
        modal.find('.modal-body #email').text($('#form-email').val());
        previewImage(document.getElementById('form-file'));
    });
</script>
