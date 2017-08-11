<?php if (success()->exists()) : ?>
    <div class="alert alert-success" role="alert">
        <?= success()->get('message') ; ?>
    </div>

    <?php success()->clear() ; ?>
    <?php (new Core\Session\RequestSessionStorage())->clear() ; ?>
<?php endif; ?>
