<?php if (errors()->exists()) : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
                <ul>
                    <?php foreach (errors()->all() as $error) : ?>
                        <li><?= $error[0] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>