<?php /** @var string[] $errors */ ?>

<h1 class="title-4">Ajouter un groupe</h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('groups') ?>

<a href="<?= url('groups.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des groupes
</a>
