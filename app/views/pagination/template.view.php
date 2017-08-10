<?php if ($paginator->hasPages()) : ?>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li>
                <?php if ($paginator->hasPreviousPage()) : ?>
                    <a href="<?= $paginator->previousPageUrl() ; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                <?php else : ?>
                    <span>&laquo;</span>
                <?php endif; ?>
            </li>

            <?php foreach ($paginator->pages() as $page => $url) : ?>
                <li class="<?= $page == $paginator->currentPage() ? 'active' : ''; ?>">
                    <a href="<?= htmlspecialchars($url); ?>"><?= htmlspecialchars($page) ?></a>
                </li>
            <?php endforeach; ?>

            <li>
                <?php if ($paginator->hasNextPage()) : ?>
                    <a href="<?= $paginator->nextPageUrl() ; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                <?php else : ?>
                    <span>&raquo;</span>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
<?php endif; ?>