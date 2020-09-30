<?php
/** @var \ESGI\Models\SettingsModel $setting */
/** @var string[] $errors */
?>

<h1 class="title-4">Configuration du réglage "<?= htmlentities($setting->getLabel()) ?>"</h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('settings', $setting) ?>

<a href="<?= url('settings.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la configuration du site
</a>
