<?php /** @var \ESGI\Models\AnnouncementsModel $announcement */ ?>
<?php /** @var \ESGI\Models\ModulesModel[] $modules */ ?>

<?= view('page', [
    'modules' => array_filter($modules, static function ($module) {
        return $module->getName() !== 'footer';
    })
]) ?>

<div class="row margin-top-40">
    <div class="col-12 col-md-8">
        <div class="card">
            <img class="card-image" src="<?= $announcement->getPicture(); ?>" alt="Announcement">
            <h3 class="card-title title-3">
                <?= \ESGI\Models\AnnouncementsModel::TYPES[$announcement->getType()] ?> à
                <?php $address = explode(' ', $announcement->getProperty()->getAddress()) ?>
                <?= end($address) ?>
            </h3>
            <div class="card-text"><?= trim($announcement->getDescription()) ?></div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <h4 class="title-4">
            <?= \ESGI\Models\BatchesModel::TYPES[$announcement->getBatch()->getType()] ?>,
            <?= lcfirst(\ESGI\Models\AnnouncementsModel::TYPES[$announcement->getType()]) ?>
        </h4>

        <strong class="title-4 display-block margin-bottom-20">
            <?= $announcement->getPrice() . ' €' . ($announcement->getType() === 1 ? ' <small>cc/mois</small>' : '') ?>
        </strong>

        <div class="card">
            <h5 class="card-title title-5">+ d'infos sur le bien</h5>
            <div class="card-text">
                <?php $url = 'https://www.google.fr/maps/search/' . urlencode($announcement->getProperty()->getAddress()) ?>
                <a href="<?= $url ?>" class="link" target="_blank">
                    <?php if ($announcement->getType() === 1): ?>
                        n°<?= $announcement->getBatch()->getNumber() ?>,
                    <?php endif; ?>
                    <?= $announcement->getProperty()->getAddress() ?>
                </a>

                <ul class="padding-left-20">
                    <li>Surface : <?= $announcement->getBatch()->getSurface() ?> m<sup>2</sup></li>
                    <li>Construction : <?= $announcement->getProperty()->getConstructionDate() ?></li>
                </ul>
            </div>
        </div>

        <div class="card">
            <h5 class="card-title title-5">+ d'infos sur l'annonce</h5>
            <div class="card-text">
                <ul class="padding-left-20">
                    <li>Mise en ligne : <?= $announcement->getCreatedAt() ?></li>
                    <li>Dernière mise à jour : <?= $announcement->getUpdatedAt() ?></li>
                    <li>
                        Annonceur :
                        <?= $announcement->getUser()->getLastname() ?>
                        <?= $announcement->getUser()->getFirstname() ?>
                    </li>
                </ul>

                <button class="button button-blue">Contacter l'annonceur</button>
                <a href="<?= url('announcements.report') ?>?id=<?= $announcement->getId() ?>" class="link link-block">Signaler</a>

                <p class="margin-top-20">
                    <i>
                        Cet annonceur ne souhaite pas rendre publique son numéro de téléphone. Veuillez utiliser le
                        formulaire de contact annonceur, accessible via le bouton ci-dessus.
                    </i>
                </p>
            </div>
        </div>
    </div>
</div>

<a href="<?= url('announcements.show') ?>" class="link display-inline">
    <?= icon('back') ?>
    Retour aux annonces disponibles
</a>

<?= view('page', [
    'modules' => array_filter($modules, static function ($module) {
        return $module->getName() === 'footer';
    })
]) ?>
