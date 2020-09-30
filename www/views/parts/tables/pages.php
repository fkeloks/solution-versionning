<?php /** @var \ESGI\Models\PagesModel[] $pages */ ?>

<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Chemin</th>
        <th>Statut</th>
        <th class="cell-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($pages ?? [])): ?>
        <tr>
            <td colspan="5">
                <a href="<?= url('pages.add') ?>" class="link">
                    <?= icon('add') ?>
                    Ajouter une page
                </a>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($pages as $page): ?>
            <tr>
                <td><?= $page->getId() ?></td>
                <td><?= htmlentities($page->getTitle()) ?></td>
                <td><?= htmlentities($page->getPath()) ?></td>
                <td><?= ['Caché', 'Publié', 'Brouillon'][$page->getStatus()] ?></td>
                <td class="cell-right">
                    <a href="<?= url('pages.edit') ?>?id=<?= $page->getId() ?>" class="link">Modifier</a>
                    <a href="<?= url('pages.delete') ?>?id=<?= $page->getId() ?>" class="link">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
