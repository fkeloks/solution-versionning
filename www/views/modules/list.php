<?php /** @var \ESGI\Models\ModulesModel $module */ ?>

<ul>
    <?php foreach ($module->getContent()['input'] ?? [] as $element): ?>
        <li><?= htmlentities($element['element']) ?? '' ?></li>
    <?php endforeach; ?>
</ul>