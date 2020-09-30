<h1 class="title-4">Ajouter un propriétaire</h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('owners'); ?>

<a href="<?= url('owners.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des propriétaires
</a>
