<?php /** @var \ESGI\Models\ModulesModel $module */ ?>

<a href="<?= htmlentities($module->getContent()['link']) ?? '' ?>" class="link"><?= htmlentities($module->getContent()['name']) ?? '' ?></a>