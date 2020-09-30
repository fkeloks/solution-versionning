<?php /** @var \ESGI\Models\ModulesModel $module */ ?>

<form action="<?= $module->getContent()['input']['link'] ?? '' ?>" method="post">
    <?php foreach ($module->getContent()['input'] ?? [] as $input): ?>
        <div class="header-link">
            <input type="text" placeholder="<?= htmlentities($input['field']) ?? '' ?>">
        </div>
    <?php endforeach; ?>
    <button class="button-blue" type="submit">Valider</button>
</form>