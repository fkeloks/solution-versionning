<?php /** @var array $files */ ?>

<h1 class="title-4">Liste des médias</h1>

<div class="card">
    <h5 class="card-title title-5"><?= icon('add') ?> Ajouter un média</h5>
    <div class="card-text">
        <form action="<?= url('medias.upload') ?>?json=false" method="post" class="form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file">Fichier à mettre en ligne :</label>
                <input type="file" name="file" id="file" required>
            </div>

            <input type="submit" class="button button-black button-small" value="Mettre en ligne">
        </form>
    </div>
</div>

<?php if (empty($files)): ?>
    <div class="card">
        <h6 class="card-title title-5">Aucun média ne semble avoir été mis en ligne...</h6>
    </div>
<?php else: ?>
    <div class="row margin-top-20">
        <?php foreach ($files as $file): ?>
            <div class="col-12 col-sm-3">
                <div class="card">
                    <div class="card-text margin-top-20">
                        <?php if ($file['type'] === 'image'): ?>
                            <img src="<?= $file['url'] ?>" class="full-width" alt="">
                        <?php elseif ($file['type'] === 'video'): ?>
                            <video src="<?= $file['url'] ?>" class="full-width" controls></video>
                        <?php else: ?>
                            <i>Fichier non supporté.</i>
                        <?php endif; ?>

                        <a href="<?= url('medias.delete') ?>?src=<?= $file['url'] ?>" class="link color-red">
                            Supprimer
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<a href="<?= url('administration') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à l'accueil de l'administration
</a>
