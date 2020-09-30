<?php /** @var \ESGI\Models\BatchesModel[] $batches */ ?>

<div class="flex">
    <h1 class="title-4">Liste des lots</h1>

    <a href="<?= url('batches.add') ?>" class="link link-float-right">
        <?= icon('add') ?>
        Ajouter un lot
    </a>
</div>

<table class="table">
    <thead>
    <tr>
        <th>ID</th>
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
        <?php foreach ($batches as $batch): ?>
            <tr>
                <td><?= $batch->getId() ?></td>
                <td><?= $batch->getNumber() ?></td>
                <td><?= \ESGI\Models\BatchesModel::TYPES[$batch->getType()] ?></td>
                <td class="cell-right"><?= $batch->getSurface() ?> m<sup>2</sup></td>
                <td>
                    <?php if ($batch->getProperty()): ?>
                        <a href="<?= url('properties.edit') ?>?id=<?= $batch->getProperty()->getId() ?>" class="link">
                            <?= htmlentities($batch->getProperty()->getAddress()) ?>
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

<a href="<?= url('administration') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à l'accueil de l'administration
</a>
