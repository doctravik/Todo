<div class="modal fade" id="attachImageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Attach image to the task</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <form method="POST" enctype="multipart/form-data" id="attach-form">
                            <div class="form-group">
                                <label for="file">File input</label>
                                <input type="file" id="file" name="image">
                            </div>
                        </form>  
                    </div>
                    <div class="col-md-6">
                        <image src="" alt="preview" id="preview-image" class="img-128 is-hidden">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="attachButton">Attach</button>
            </div>
        </div>
    </div>
</div>