<?php /** @var \ESGI\Models\ModulesModel[] $modules */ ?>
<?php /** @var \ESGI\Models\AnnouncementsModel[] $announcements */ ?>
<?php /** @var int $announcements_count */ ?>

<?= view('page', [
    'modules' => array_filter($modules, static function ($module) {
        return htmlentities($module->getName()) !== 'footer';
    })
]) ?>

<div class="row">
    <div class="col-12 col-md-8 margin-bottom-20">
        <h1 class="title-4">
            <?= $announcements_count ?> annonce<?= $announcements_count > 1 ? 's' : '' ?>
            disponible<?= $announcements_count > 1 ? 's' : '' ?>
        </h1>
        <p>
            Pour garantir votre confort de navigation, seuls les 12 premiers résultats ont été affichés.
            <br>
            Nous vous conseillons d'affiner vos critères de recherche.
        </p>
    </div>
    <div class="col-12 col-md-4">
        <form action="<?= url('announcements.show') ?>?page=<?= \ESGI\Core\Database\Pagination::getPage() ?>" method="get" class="form margin-bottom-20">
            <input type="hidden" name="page" id="page" value="<?= \ESGI\Core\Database\Pagination::getPage() ?>">
            <div class="form-group">
                <label for="display">Affichage</label>
                <select name="display" id="display" onchange="this.parentNode.parentNode.submit()">
                    <option value="card" <?= ($_GET['display'] ?? 'card') === 'card' ? 'selected' : '' ?>>Affichage en
                        carte
                    </option>
                    <option value="list" <?= ($_GET['display'] ?? 'card') === 'list' ? 'selected' : '' ?>>Affichage en
                        liste
                    </option>
                </select>
            </div>
        </form>
    </div>
    <div class="col-12">
        <form action="" method="get" class="form margin-bottom-20">
            <div class="row">
                <div class="col-12 col-md-2">
                    <div class="form-group margin-bottom-10">
                        <label for="announcement_type">Type d'annonce</label>
                        <select name="announcement_type" id="announcement_type">
                            <option value="0" <?= ($_GET['announcement_type'] ?? '') === '0' ? 'selected' : '' ?>>
                                Locations & Ventes
                            </option>
                            <option value="1" <?= ($_GET['announcement_type'] ?? '') === '1' ? 'selected' : '' ?>>
                                Locations
                            </option>
                            <option value="2" <?= ($_GET['announcement_type'] ?? '') === '2' ? 'selected' : '' ?>>
                                Ventes
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group margin-bottom-10">
                        <label for="batch_type">Type de propriété</label>
                        <select name="batch_type" id="batch_type">
                            <option value="0" <?= ($_GET['batch_type'] ?? '') === '0' ? 'selected' : '' ?>>
                                Appartements & Maisons
                            </option>
                            <option value="2" <?= ($_GET['batch_type'] ?? '') === '2' ? 'selected' : '' ?>>
                                Appartements
                            </option>
                            <option value="1" <?= ($_GET['batch_type'] ?? '') === '1' ? 'selected' : '' ?>>
                                Maisons
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group margin-bottom-10">
                        <label for="announcement_min">Prix minimum / maximum</label>
                        <div class="form-group form-group-inline">
                            <input type="number" name="announcement_min" id="announcement_min" placeholder="Prix minimum" value="<?= $_GET['announcement_min'] ? htmlentities($_GET['announcement_min']) : '' ?>" aria-label="Prix minimum souhaité">
                            <input type="number" name="announcement_max" id="announcement_max" placeholder="Prix maximum" value="<?= $_GET['announcement_max'] ? htmlentities($_GET['announcement_max']) : '' ?>" aria-label="Prix maximum souhaité">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group margin-bottom-10">
                        <label for="sort">Tri</label>
                        <select name="sort" id="sort">
                            <option value="1" <?= ($_GET['sort'] ?? '') === '1' ? 'selected' : '' ?>>
                                Date la plus récente
                            </option>
                            <option value="2" <?= ($_GET['sort'] ?? '') === '2' ? 'selected' : '' ?>>
                                Prix croissant
                            </option>
                            <option value="3" <?= ($_GET['sort'] ?? '') === '3' ? 'selected' : '' ?>>
                                Prix décroissant
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <div class="form-group margin-bottom-10">
                        <label class="fake-label" aria-hidden="true">-</label>
                        <div class="form-group text-right">
                            <input class="button button-small button-black display-inline" type="submit" value="Filtrer les annonces">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (empty($announcements ?? [])): ?>
    <h3 class="title-5">Aucune annonce.</h3>
<?php else: ?>
    <?php if (($_GET['display'] ?? 'card') === 'card'): ?>
        <div class="row">
            <?php foreach ($announcements ?? [] as $announcement): ?>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card">
                        <a class="card-link" href="<?= url('announcements.show') ?>/<?= $announcement->getId() ?>">
                            <img class="card-image" src="<?= $announcement->getPicture(); ?>" alt="Announcement">
                            <h3 class="card-title title-3">
                                <?= \ESGI\Models\BatchesModel::TYPES[$announcement->getBatch()->getType()] ?>,
                                <?= \ESGI\Models\AnnouncementsModel::TYPES[$announcement->getType()] ?> à
                                <?php $address = explode(' ', $announcement->getProperty()->getAddress()) ?>
                                <?= end($address) ?>
                            </h3>
                            <div class="card-text">
                                <div class="row">
                                    <div class="col-9">
                                        <h4 class="title-4">
                                            <?= $announcement->getPrice() . ' €' . ($announcement->getType() === 1 ? ' <small>cc/mois</small>' : '') ?>
                                        </h4>
                                        <ul class="padding-left-20">
                                            <li>
                                                Surface : <?= $announcement->getBatch()->getSurface() ?> m<sup>2</sup>
                                            </li>
                                            <li>
                                                Construction
                                                : <?= $announcement->getProperty()->getConstructionDate() ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <?php foreach ($announcements ?? [] as $announcement): ?>
            <div class="card">
                <h3 class="card-title title-3">
                    <a href="<?= url('announcements.show') ?>/<?= $announcement->getId() ?>">
                        <?= \ESGI\Models\BatchesModel::TYPES[$announcement->getBatch()->getType()] ?>,
                        <?= \ESGI\Models\AnnouncementsModel::TYPES[$announcement->getType()] ?> à
                        <?php $address = explode(' ', $announcement->getProperty()->getAddress()) ?>
                        <?= end($address) ?>
                    </a>
                </h3>
                <div class="card-text">
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <img class="card-image" src="<?= $announcement->getPicture(); ?>" alt="Announcement">
                        </div>
                        <div class="col-12 col-sm-9">
                            <div class="margin-bottom-20">
                                <div class="float-right">
                                    Surface :
                                    <strong><?= htmlentities($announcement->getBatch()->getSurface()) ?> m<sup>2</sup></strong>,
                                    Construction :
                                    <strong><?= $announcement->getProperty()->getConstructionDate() ?></strong>
                                </div>
                                <h4 class="title-4 margin-bottom-20">
                                    <?= htmlentities($announcement->getPrice()) . ' €' . ($announcement->getType() === 1 ? ' <small>ht/mois</small>' : '') ?>
                                </h4>
                            </div>
                            <?= htmlentities(trim($announcement->getDescription())) ?>
                            <div class="margin-top-20">
                                <?php $url = 'https://www.google.fr/maps/search/' . urlencode($announcement->getProperty()->getAddress()) ?>
                                <a href="<?= $url ?>" class="link display-inline" target="_blank">
                                    <?php if ($announcement->getType() === 1): ?>
                                        n°<?= $announcement->getBatch()->getNumber() ?>,
                                    <?php endif; ?>
                                    <?= htmlentities($announcement->getProperty()->getAddress()) ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>

<?= view('parts.pagination', ['table' => \ESGI\Models\AnnouncementsModel::getTableName()]) ?>

<?= view('page', [
    'modules' => array_filter($modules, static function ($module) {
        return $module->getName() === 'footer';
    })
]) ?>
