<?php /** @var \ESGI\Models\PropertiesModel[] $properties */ ?>

<table class="table">
    <thead>
    <tr>
        <th>Type</th>
        <th>Adresse</th>
        <th>Date de Construction</th>
        <th class="cell-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($properties ?? [])): ?>
        <tr>
            <td colspan="4">
                <a href="<?= url('properties.add') ?>" class="link">
                    <?= icon('add') ?>
                    Ajouter une propriété
                </a>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($properties as $property): ?>
            <tr>
                <td><?= \ESGI\Models\PropertiesModel::TYPES[$property->getType()] ?></td>
                <td><?= htmlentities($property->getAddress()) ?></td>
                <td><?= $property->getConstructionDate() ?></td>
                <td class="cell-right">
                    <a href="<?= url('properties.edit') ?>?id=<?= $property->getId() ?>" class="link">Modifier</a>
                    <a href="<?= url('properties.delete') ?>?id=<?= $property->getId() ?>" class="link">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
