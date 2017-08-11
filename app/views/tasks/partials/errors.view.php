<?php if (errors()->exists()) : ?>
    <div class="alert alert-danger" role="alert">
        <ul>
            <?php foreach (errors()->all() as $error) : ?>
                <li><?= $error[0] ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>