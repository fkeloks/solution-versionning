<?php /** @var \ESGI\Models\OwnersModel $owner */ ?>

<h1 class="title-4">Edition du propriétaire n°<?= $owner->getId() ?></h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('owners', $owner); ?>

<a href="<?= url('owners.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des propriétaires
</a>
