<?php /** @var \ESGI\Models\PropertiesModel[] $properties */ ?>

<div class="flex">
    <h1 class="title-4">Liste des propriétés</h1>

    <a href="<?= url('properties.add') ?>" class="link link-float-right">
        <?= icon('add') ?>
        Ajouter une propriété
    </a>
</div>

<?= view('parts/tables/properties', ['properties' => $properties]) ?>

<?= view('parts.pagination', ['table' => \ESGI\Models\PropertiesModel::getTableName()]) ?>

<a href="<?= url('administration') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à l'accueil de l'administration
</a>
