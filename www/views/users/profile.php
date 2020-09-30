<?php /** @var \ESGI\Models\UsersModel $user */ ?>
<?php /** @var string[] $errors */ ?>

<h1 class="title-4">Edition de mon profil</h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('users', $user) ?>

<a href="<?= url('administration') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour au dashboard
</a>
