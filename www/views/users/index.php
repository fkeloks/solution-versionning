<?php /** @var \ESGI\Models\UsersModel[] $users */ ?>

<div class="flex">
    <h1 class="title-4">Liste des utilisateurs du site</h1>

    <a href="<?= url('users.add') ?>" class="link link-float-right">
        <?= icon('add') ?>
        Ajouter un utilisateur
    </a>
</div>

<?= view('parts/tables/users', ['users' => $users]) ?>

<?= view('parts.pagination', ['table' => \ESGI\Models\UsersModel::getTableName()]) ?>

<a href="<?= url('administration') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à l'accueil de l'administration
</a>
