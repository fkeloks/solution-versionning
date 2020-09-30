<h1 class="title-4">Ajouter une page</h1>

<?php if (!empty($errors)): ?>
    <?= view('parts/errors', ['errors' => $errors]); ?>
<?php endif ?>

<?= form('pages') ?>

<a href="<?= url('pages.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des pages
</a>
