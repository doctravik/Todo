<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edit task</h4>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group <?= errors('content')->exists() ? 'has-error' : '' ;?>">
                        <label for="content" class="control-label">Content</label>
                        <textarea id="content" name="content" class="form-control" rows="5"></textarea>

                        <?php if(errors('content')->exists()) : ?>
                            <span class="help-block">
                                <strong><?= errors('content')->first() ; ?></strong>
                            </span>
                        <?php endif ; ?>
                    </div>

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>