<?php
/** @var \ESGI\Models\UsersModel $user */
/** @var string[] $errors */
?>

<h1 class="title-4">Edition de l'utilisateur n°<?= $user->getId() ?></h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('users', $user) ?>

<a href="<?= url('users.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des utilisateurs
</a>
