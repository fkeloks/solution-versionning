<?php /** @var \ESGI\Models\OwnersModel[] $owners */ ?>

<div class="flex">
    <h1 class="title-4">Liste des propriétaires</h1>

    <a href="<?= url('owners.add') ?>" class="link link-float-right">
        <?= icon('add') ?>
        Ajouter un propriétaire
    </a>
</div>

<?= view('parts/tables/owners', ['owners' => $owners]) ?>

<?= view('parts.pagination', ['table' => \ESGI\Models\OwnersModel::getTableName()]) ?>

<a href="<?= url('administration') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à l'accueil de l'administration
</a>
