<?php /** @var \ESGI\Models\ModulesModel $module */ ?>

<h1 class="title-<?= $module->getContent()['level'] ?? 1 ?>">
    <?= htmlentities($module->getContent()['text']) ?? '' ?>
</h1>
