<?php /** @var \ESGI\Models\ModulesModel $module */ ?>

<header class="header margin-bottom-40">
    <div class="header-links">
        <?php foreach ($module->getContent()['links'] ?? [] as $link): ?>
            <div class="header-link">
                <?php $path = str_replace('%2F', '/', urlencode($link['link'] ?? '')); ?>
                <a href="<?= htmlentities($path) ?>"><?= htmlentities($link['label']) ?? '' ?></a>
            </div>
        <?php endforeach; ?>
    </div>
</header>
