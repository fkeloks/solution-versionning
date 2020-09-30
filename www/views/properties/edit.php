<?php
/** @var \ESGI\Models\PropertiesModel $property */
/** @var string[] $errors */
?>

<h1 class="title-4">Edition de la propriété n°<?= $property->getId() ?></h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('properties', $property) ?>

<a href="<?= url('properties.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des propriétés
</a>
