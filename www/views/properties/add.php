<?php /** @var string[] $errors */ ?>

<h1 class="title-4">Ajouter une propriété</h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('properties') ?>

<a href="<?= url('properties.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des propriétés
</a>
