<?php /** @var \ESGI\Models\ModulesModel $module */ ?>

<div class="row margin-top-40 cards-wrapper">
    <div class="card">
        <p class="card-title title-4">
            <?= nl2br($module->getContent()['title'] ?? '') ?>
        </p>
        <p class="card-text"><?= nl2br($module->getContent()['text'] ?? '') ?></p>
    </div>
</div>
