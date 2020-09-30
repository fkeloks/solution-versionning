<?php /** @var array $errors */ ?>

<h1 class="title-3">Connexion</h1>
<h3 class="title-4 margin-bottom-40">Heureux de vous revoir</h3>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('auth') ?>

<hr>

<h2 class="title-5 margin-top-40">Vous n'avez pas encore de compte ?</h2>
<a href="<?= url('auth.register') ?>" class="link">M'inscrire</a>
