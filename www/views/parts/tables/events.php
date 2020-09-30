<?php /** @var ESGI\Models\EventsModel[] $events */ ?>

<table class="table">
    <thead>
    <tr>
        <th>Nom</th>
        <th>Date de début</th>
        <th>Date de fin</th>
        <th>Heure de début</th>
        <th>Heure de fin</th>
        <th class="cell-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($events ?? [])): ?>
        <tr>
            <td colspan="6">
                <a href="<?= url('events.add') ?>" class="link">
                    <?= icon('add') ?>
                    Ajouter un évènement
                </a>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?= htmlentities($event->getName()) ?></td>
                <td><?= htmlentities($event->getDateStart()) ?></td>
                <td><?= htmlentities($event->getDateEnd()) ?></td>
                <td><?= htmlentities($event->getTimeStart()) ?></td>
                <td><?= htmlentities($event->getTimeEnd()) ?> </td>
                <td class="cell-right">
                    <a href="<?= url('events.edit') ?>?id=<?= $event->getId() ?>" class="link">Modifier</a>
                    <a href="<?= url('events.delete') ?>?id=<?= $event->getId() ?>" class="link">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
