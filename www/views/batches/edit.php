<?php /** @var \ESGI\Models\BatchesModel $batch */ ?>

<h1 class="title-4">Edition du lot n°<?= $batch->getId() ?></h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('batches', $batch); ?>

<a href="<?= url('batches.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des lots
</a>
