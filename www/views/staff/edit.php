<?php
/** @var \ESGI\Models\StaffModel $staff */
/** @var string[] $errors */
?>

<h1 class="title-4">Edition du membre n°<?= $staff->getId() ?></h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('staff', $staff); ?>

<a href="<?= url('staff.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste du personnel
</a>
