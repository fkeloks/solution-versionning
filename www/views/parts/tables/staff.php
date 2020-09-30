<?php /** @var \ESGI\Models\StaffModel[] $staff */ ?>

<table class="table">
    <thead>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Fonction</th>
        <th class="cell-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($staff ?? [])): ?>
        <tr>
            <td colspan="4">
                <a href="<?= url('staff.add') ?>" class="link">
                    <?= icon('add') ?>
                    Ajouter
                </a>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($staff as $member): ?>
            <tr>
                <td><?= htmlentities($member->getLastname()) ?></td>
                <td><?= htmlentities($member->getFirstName()) ?></td>
                <td><?= htmlentities($member->getFunction()) ?></td>
                <td class="cell-right">
                    <a href="<?= url('staff.edit') ?>?id=<?= $member->getId() ?>" class="link">Modifier</a>
                    <a href="<?= url('staff.delete') ?>?id=<?= $member->getId() ?>" class="link">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
