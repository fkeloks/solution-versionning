<?php /** @var \ESGI\Models\UsersModel[] $users */ ?>

<table class="table">
    <thead>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Groupe</th>
        <th class="cell-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($users ?? [])): ?>
        <tr>
            <td colspan="5">
                <a href="<?= url('users.add') ?>" class="link">
                    <?= icon('add') ?>
                    Ajouter un utilisateur
                </a>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlentities($user->getLastname()) ?></td>
                <td><?= htmlentities($user->getFirstname()) ?></td>
                <td><?= htmlentities($user->getEmail()) ?></td>
                <td><?= $user->getGroup() ? htmlentities($user->getGroup()->getName()) : '-' ?></td>
                <td class="cell-right">
                    <a href="<?= url('users.edit') ?>?id=<?= $user->getId() ?>" class="link">Modifier</a>
                    <a href="<?= url('users.delete') ?>?id=<?= $user->getId() ?>" class="link">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
