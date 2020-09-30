<?php /** @var array $errors */ ?>

<h1 class="title-3">Inscription</h1>
<h3 class="title-4 margin-bottom-40">Bienvenue parmi nous !</h3>

<?= view('parts.errors', ['errors' => $errors]) ?>

<?= form('auth') ?>

<hr>

<h2 class="title-5 margin-top-40">Vous avez déjà un compte ?</h2>
<a href="<?= url('auth.login') ?>" class="link">Me connecter</a>
