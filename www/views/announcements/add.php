<h1 class="title-4">Publier une annonce</h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('announcements') ?>

<a href="<?= url('announcements.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des annonces
</a>
