<?php /** @var string[] $errors */ ?>

<h1 class="title-4">EfysImmobilier - Installation</h1>

<?= view('parts.errors', ['errors' => $errors]) ?>

<?= form('install') ?>

<p class="margin-top-20">
    Important : un email de test va vous être envoyé après la soumission du formulaire.<br>
    Veuillez vérifier votre boite de reception.
</p>
