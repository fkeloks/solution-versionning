<?php

/** @var string $table */

use ESGI\Core\Database\Pagination;

$page = Pagination::getPage();
$count = Pagination::getPageCount($table);
?>

<?php if ($count > 1): ?>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= 1 ?>" class="pagination-item" title="Première page">❬❬</a>
            <a href="?page=<?= $page - 1 ?>" class="pagination-item" title="Page précédente">❬</a>
        <?php endif; ?>

        <?php if ($page <= 4): ?>
            <?php for ($i = 1, $iMax = min(7, $count); $i <= $iMax; $i++): ?>
                <a href="?page=<?= $i ?>" class="pagination-item <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($count > 4): ?>
                <span class="pagination-item">...</span>
            <?php endif; ?>
        <?php elseif ($count > 7): ?>
            <span class="pagination-item">...</span>

            <?php for ($i = ($page - 3); $i <= ($page - 1); $i++): ?>
                <a href="?page=<?= $i ?>" class="pagination-item <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php for ($i = $page, $iMax = min($page + 3, $count); $i <= $iMax; $i++): ?>
                <a href="?page=<?= $i ?>" class="pagination-item <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($page < ($count - 3)): ?>
                <span class="pagination-item">...</span>
            <?php endif; ?>
        <?php else: ?>
            <?php for ($i = 1; $i <= $count; $i++): ?>
                <a href="?page=<?= $i ?>" class="pagination-item <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        <?php endif; ?>

        <?php if ($page < $count): ?>
            <a href="?page=<?= $page + 1 ?>" class="pagination-item" title="Page suivante">❭</a>
            <a href="?page=<?= $count ?>" class="pagination-item" title="Dernière page">❭❭</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
