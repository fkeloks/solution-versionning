<?php /** @var \ESGI\Models\ModulesModel $module */ ?>

<footer class="footer margin-top-40">
    <div class="footer-links">
        <?php foreach ($module->getContent()['links'] ?? [] as $link): ?>
            <div class="footer-link">
                <?php $path = str_replace('%2F', '/', urlencode($link['link'] ?? '')); ?>
                <a href="<?= htmlentities($path) ?>"><?= htmlentities($link['label']) ?? '' ?></a>
            </div>
        <?php endforeach; ?>
    </div>
</footer>
