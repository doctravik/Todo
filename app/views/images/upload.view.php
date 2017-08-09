<form action="<?= 'tasks/' . $task->id . '/image/upload' ; ?>" 
    method="POST" enctype="multipart/form-data">
    <label for="file">
        <span>Attach image</span>
        <!-- <input type="hidden" name="MAX_FILE_SIZE" value="10000"> -->
        <input type="file" id="file" name="image">
    </label>
    <?php if(errors('image')->exists()) : ?>
        <span>
            <strong><?= errors('image')->first() ; ?></strong>
        </span>
    <?php endif ; ?>

    <button>Upload</button>
</form>

<image src="<?= $task->image ?>">