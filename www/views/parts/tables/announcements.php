<?php /** @var \ESGI\Models\AnnouncementsModel[] $announcements */ ?>

<table class="table">
    <thead>
    <tr>
        <th>Type</th>
        <th>Lot</th>
        <th class="cell-right">Prix / Loyer</th>
        <th class="cell-right">Annonceur</th>
        <th>Mise en ligne</th>
        <th class="cell-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($announcements ?? [])): ?>
        <tr>
            <td colspan="6">
                <a href="<?= url('announcements.add') ?>" class="link">
                    <?= icon('add') ?>
                    Ajouter une annonce
                </a>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($announcements as $announcement): ?>
            <tr>
                <td>
                    <?= \ESGI\Models\AnnouncementsModel::TYPES[$announcement->getType()] ?>
                    <?php if ($announcement->getBatch()): ?>
                        -
                        <?= \ESGI\Models\BatchesModel::TYPES[$announcement->getBatch()->getType()] ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($announcement->getBatch()): ?>
                        <a href="<?= url('batches.edit') ?>?id=<?= $announcement->getBatch()->getId() ?>" class="link">
                            <?php if ($announcement->getType() === 1): ?>
                                n°<?= $announcement->getBatch()->getNumber() ?>,
                            <?php endif; ?>
                            <?= htmlentities($announcement->getProperty()->getAddress()) ?>
                            <small>(<?= $announcement->getBatch()->getSurface() ?> m<sup>2</sup>)</small>
                        </a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td class="cell-right"><?= $announcement->getPrice() ?>€</td>
                <td>
                    <?php if ($announcement->getUser()): ?>
                        <?= htmlentities($announcement->getUser()->getLastname()) . ' ' . htmlentities($announcement->getUser()->getFirstname()) ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
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
