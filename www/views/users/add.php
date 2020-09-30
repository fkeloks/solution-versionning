<?php /** @var string[] $errors */ ?>

<h1 class="title-4">Ajouter un utilisateur</h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('users') ?>

<a href="<?= url('users.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des utilisateurs
</a>
