<?php /** @var \ESGI\Models\ModulesModel $module */ ?>

<div class="row banner margin-top-40 margin-bottom-40">
    <span class="banner-background" aria-hidden="true"></span>
    <?php foreach ($module->getContent()['sections'] ?? [] as $section): ?>
        <div class="col-12 col-md-4 banner-section"><?= htmlentities($section['text']) ?? '' ?></div>
    <?php endforeach; ?>
</div>
