<?php /** @var \ESGI\Models\PagesModel[] $pages */ ?>

<div class="flex">
    <h1 class="title-4">Liste des pages</h1>

    <a href="<?= url('pages.add') ?>" class="link link-float-right">
        <?= icon('add') ?>
        Ajouter une page
    </a>
</div>

<?= view('parts/tables/pages', ['pages' => $pages]) ?>

<?= view('parts.pagination', ['table' => \ESGI\Models\PagesModel::getTableName()]) ?>

<a href="<?= url('administration') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à l'accueil de l'administration
</a>
