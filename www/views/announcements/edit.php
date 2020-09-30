<?php /** @var \ESGI\Models\AnnouncementsModel $announcement */ ?>

<h1 class="title-4">Edition de l'annonce n°<?= $announcement->getId() ?></h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('announcements', $announcement) ?>

<a href="<?= url('announcements.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des annonces
</a>
