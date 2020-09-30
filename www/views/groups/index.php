<?php /** @var \ESGI\Models\GroupsModel[] $groups */ ?>

<div class="flex">
    <h1 class="title-4">Liste des groupes</h1>

    <a href="<?= url('groups.add') ?>" class="link link-float-right">
        <?= icon('add') ?>
        Ajouter un groupe
    </a>
</div>

<?= view('parts/tables/groups', ['groups' => $groups]) ?>

<small class="display-inline-block margin-top-20">Seul le groupe par défaut à accès à cette page.</small>

<a href="<?= url('administration') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à l'accueil de l'administration
</a>
