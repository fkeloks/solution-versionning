<?php /** @var string[] $errors */ ?>

<h1 class="title-4">Ajouter un membre</h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('staff'); ?>

<a href="<?= url('staff.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des membres
</a>
