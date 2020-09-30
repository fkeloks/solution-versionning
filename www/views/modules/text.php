<?php /** @var \ESGI\Models\ModulesModel $module */ ?>

<p><?= htmlentities(nl2br($module->getContent()['text'] ?? '')) ?></p>
