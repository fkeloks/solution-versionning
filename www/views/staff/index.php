<?php /** @var \ESGI\Models\StaffModel[] $staff */ ?>

<div class="flex">
    <h1 class="title-4">Liste des membres du personnel</h1>

    <a href="<?= url('staff.add') ?>" class="link link-float-right">
        <?= icon('add') ?>
        Ajouter un membre
    </a>
</div>

<?= view('parts/tables/staff', ['staff' => $staff]) ?>

<?= view('parts.pagination', ['table' => \ESGI\Models\StaffModel::getTableName()]) ?>

<a href="<?= url('administration') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à l'accueil de l'administration
</a>
