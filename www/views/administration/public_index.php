<?php /** @var \ESGI\Models\PropertiesModel[] $properties */ ?>
<?php /** @var \ESGI\Models\BatchesModel[] $batches */ ?>
<?php /** @var \ESGI\Models\AnnouncementsModel[] $announcements */ ?>

<div class="flex">
    <h1 class="title-4">Liste de mes propriétés</h1>

    <a href="<?= url('properties.add') ?>" class="link link-float-right">
        <?= icon('add') ?>
        Ajouter une propriété
    </a>
</div>

<?= view('parts/tables/properties', ['properties' => $properties]) ?>

<?= view('parts.pagination', ['table' => \ESGI\Models\PropertiesModel::getTableName()]) ?>

<hr>

<div class="flex">
    <h1 class="title-4">Liste de mes lots</h1>

    <a href="<?= url('batches.add') ?>" class="link link-float-right">
        <?= icon('add') ?>
        Ajouter un lot
    </a>
</div>

<table class="table">
    <thead>
    <tr>
        <th>Numéro</th>
        <th>Type</th>
        <th class="cell-right">Superficie</th>
        <th>Propriété</th>
        <th class="cell-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($batches ?? [])): ?>
        <tr>
            <td colspan="6">
                <a href="<?= url('batches.add') ?>" class="link">
                    <?= icon('add') ?>
                    Ajouter un lot
                </a>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($batches ?? [] as $batch): ?>
            <tr>
                <td><?= $batch->getNumber() ?></td>
                <td><?= \ESGI\Models\BatchesModel::TYPES[$batch->getType()] ?></td>
                <td class="cell-right"><?= $batch->getSurface() ?> m<sup>2</sup></td>
                <td>
                    <?php if ($batch->getProperty()): ?>
                        <a href="<?= url('properties.edit') ?>?id=<?= $batch->getProperty()->getId() ?>" class="link">
                            <?= $batch->getProperty()->getAddress() ?>
                        </a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td class="cell-right">
                    <a href="<?= url('batches.edit') ?>?id=<?= $batch->getId() ?>" class="link">Modifier</a>
                    <a href="<?= url('batches.delete') ?>?id=<?= $batch->getId() ?>" class="link">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<?= view('parts.pagination', ['table' => \ESGI\Models\BatchesModel::getTableName()]) ?>

<hr>

<div class="flex">
    <h1 class="title-4">Liste de mes annonces</h1>

    <a href="<?= url('announcements.add') ?>" class="link link-float-right">
        <?= icon('add') ?>
        Publier une annonce
    </a>
</div>

<table class="table">
    <thead>
    <tr>
        <th>Type</th>
        <th>Lot</th>
        <th class="cell-right">Prix / Loyer</th>
        <th>Mise en ligne</th>
        <th class="cell-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($announcements ?? [])): ?>
        <tr>
            <td colspan="5">
                <a href="<?= url('announcements.add') ?>" class="link">
                    <?= icon('add') ?>
                    Publier une annonce
                </a>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($announcements ?? [] as $announcement): ?>
            <tr>
                <td>
                    <?= \ESGI\Models\AnnouncementsModel::TYPES[$announcement->getType()] ?>
                    -
                    <?= \ESGI\Models\BatchesModel::TYPES[$announcement->getBatch()->getType()] ?>
                </td>
                <td>
                    <a href="<?= url('batches.edit') ?>?id=<?= $announcement->getBatch()->getId() ?>" class="link">
                        <?php if ($announcement->getType() === 1): ?>
                            n°<?= $announcement->getBatch()->getNumber() ?>,
                        <?php endif; ?>
                        <?= $announcement->getProperty()->getAddress() ?>
                        <small>(<?= $announcement->getBatch()->getSurface() ?> m<sup>2</sup>)</small>
                    </a>
                </td>
                <td class="cell-right"><?= $announcement->getPrice() ?>€</td>
                <td><?= $announcement->getCreatedAt() ?></td>
                <td class="cell-right">
                    <a href="<?= url('announcements.show') ?>/<?= $announcement->getId() ?>" class="link" target="_blank">Voir</a>
                    <a href="<?= url('announcements.edit') ?>?id=<?= $announcement->getId() ?>" class="link">Modifier</a>
                    <a href="<?= url('announcements.delete') ?>?id=<?= $announcement->getId() ?>" class="link">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<?= view('parts.pagination', ['table' => \ESGI\Models\AnnouncementsModel::getTableName()]) ?>
