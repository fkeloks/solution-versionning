<?php /** @var ESGI\Models\GroupsModel[] $groups */ ?>

<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nom du groupe</th>
        <th class="cell-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($groups ?? [])): ?>
        <tr>
            <td colspan="3">
                <a href="<?= url('groups.add') ?>" class="link">
                    <?= icon('add') ?>
                    Ajouter un groupe
                </a>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($groups as $group): ?>
            <tr>
                <td><?= $group->getId() ?></td>
                <td>
                    <?= htmlentities($group->getName()) ?>
                    <?php if ($group->getId() === 1): ?>
                        <small><i>[groupe par défaut]</i></small>
                    <?php endif; ?>
                </td>
                <td class="cell-right">
                    <a href="<?= url('groups.edit') ?>?id=<?= $group->getId() ?>" class="link">Modifier</a>
                    <?php if ($group->getId() !== 1): ?>
                        <a href="<?= url('groups.delete') ?>?id=<?= $group->getId() ?>" class="link">Supprimer</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
