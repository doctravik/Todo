<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Create new task</h3>
    </div>
    <div class="panel-body">
        <form action="/tasks" method="POST">
            <div class="form-group <?= errors('username')->exists() ? 'has-error' : '' ; ?>">
                <label for="username" class="control-label">Username</label>
                <input type="text" id="username" name="username" class="form-control"  
                    value="<?= htmlspecialchars(old('username')) ; ?>" autofocus>

                <?php if(errors('username')->exists()) : ?>
                    <span class="help-block">
                        <strong><?= errors('username')->first() ; ?></strong>
                    </span>
                <?php endif ; ?>
            </div>
            
            <div class="form-group <?= errors('email')->exists() ? 'has-error' : '' ;?>">
                <label for="email" class="control-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" 
                    value="<?= htmlspecialchars(old('email')) ; ?>" >

                <?php if(errors('email')->exists()) : ?>
                    <span class="help-block">
                        <strong><?= errors('email')->first() ; ?></strong>
                    </span>
                <?php endif ; ?>
            </div>

            <div class="form-group <?= errors('content')->exists() ? 'has-error' : '' ;?>">
                <label for="content" class="control-label">Content</label>
                <textarea id="content" name="content" class="form-control" rows="5"><?php
                    htmlspecialchars(old('content')) ; 
                ?></textarea>

                <?php if(errors('content')->exists()) : ?>
                    <span class="help-block">
                        <strong><?= errors('content')->first() ; ?></strong>
                    </span>
                <?php endif ; ?>
            </div>

            <a class="btn btn-default" href="#" role="button">Preview</a>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</div>
