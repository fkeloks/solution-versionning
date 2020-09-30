<?php /** @var \ESGI\Models\SettingsModel[] $settings */ ?>

<div class="flex">
    <h1 class="title-4">Configuration du site</h1>
</div>

<table class="table">
    <thead>
    <tr>
        <th>Réglage</th>
        <th>Valeur</th>
        <th class="cell-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($settings ?? [] as $setting): ?>
        <tr>
            <td><?= htmlentities($setting->getLabel()) ?></td>
            <td><?= ($setting->getOptions() !== null ? htmlentities($setting->getOptions()[$setting->getValue()]) : htmlentities($setting->getValue())) ?></td>
            <td class="cell-right">
                <a href="<?= url('settings.edit') ?>?id=<?= $setting->getId() ?>" class="link">Modifier</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= url('administration') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à l'accueil de l'administration
</a>
