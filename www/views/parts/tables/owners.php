<?php /** @var \ESGI\Models\OwnersModel[] $owners */ ?>

<table class="table">
    <thead>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Mail</th>
        <th>Adresse</th>
        <th>Téléphone</th>
        <th class="cell-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($owners ?? [])): ?>
        <tr>
            <td colspan="6">
                <a href="<?= url('owners.add') ?>" class="link">
                    <?= icon('add') ?>
                    Ajouter
                </a>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($owners as $owner): ?>
            <tr>
                <td><?= htmlentities($owner->getLastName()) ?></td>
                <td><?= htmlentities($owner->getFirstName()) ?></td>
                <td><?= htmlentities($owner->getMail()) ?></td>
                <td><?= htmlentities($owner->getAddress()) ?></td>
                <td><?= htmlentities($owner->getPhone()) ?></td>
                <td class="cell-right">
                    <a href="<?= url('owners.edit') ?>?id=<?= $owner->getId() ?>" class="link">Modifier</a>
                    <a href="<?= url('owners.delete') ?>?id=<?= $owner->getId() ?>" class="link">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
