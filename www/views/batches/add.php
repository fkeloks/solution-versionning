<h1 class="title-4">Ajouter un lot</h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('batches'); ?>

<a href="<?= url('batches.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des lots
</a>
