<?php /** @var string[] $errors */ ?>

<h1 class="title-4">Planifier un évènement</h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('events') ?>

<a href="<?= url('planning.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des évènements
</a>
