<?php
/** @var \ESGI\Models\EventsModel $event */
/** @var string[] $errors */
?>

<h1 class="title-4">Edition de l'évènement <?= htmlentities($event->getName()) ?></h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('events', $event) ?>

<a href="<?= url('planning.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des évènements
</a>
