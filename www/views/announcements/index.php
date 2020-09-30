<?php /** @var \ESGI\Models\AnnouncementsModel[] $announcements */ ?>

<div class="flex">
    <h1 class="title-4">Liste des annonces</h1>

    <a href="<?= url('announcements.add') ?>" class="link link-float-right">
        <?= icon('add') ?>
        Publier une annonce
    </a>
</div>

<?= view('parts/tables/announcements', ['announcements' => $announcements]) ?>

<?= view('parts.pagination', ['table' => \ESGI\Models\AnnouncementsModel::getTableName()]) ?>

<a href="<?= url('administration') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à l'accueil de l'administration
</a>
