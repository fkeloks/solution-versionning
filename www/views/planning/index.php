<?php /** @var \ESGI\Models\EventsModel[] $events */ ?>

<div class="flex">
    <h1 class="title-4">Planning</h1>

    <a href="<?= url('planning.add') ?>" class="link link-float-right">
        <?= icon('add') ?>
        Planifier un évènement
    </a>
</div>

<table class="table">
    <thead>
    <tr>
        <th>Évènement</th>
        <th>Utilisateur</th>
        <th>Début</th>
        <th>Fin</th>
        <th class="cell-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($events ?? [])): ?>
        <tr>
            <td colspan="5">
                <a href="<?= url('planning.add') ?>" class="link">
                    <?= icon('add') ?>
                    Planifier
                </a>
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><small>[<?= ['Travail', 'Évènement'][$event->getType()] ?>]</small> <?= htmlentities($event->getName()) ?></td>
                <?php if ($event->getStaff()): ?>
                    <td><?= htmlentities($event->getStaff()->getLastname()) . ' ' . htmlentities($event->getStaff()->getFirstname()) ?></td>
                <?php else: ?>
                    <td>-</td>
                <?php endif; ?>
                <td><?= $event->getDateStart() ?> <?= $event->getTimeStart() ?></td>
                <td><?= $event->getDateEnd() ?> <?= $event->getTimeEnd() ?></td>
                <td class="cell-right">
                    <a href="<?= url('planning.edit') ?>?id=<?= $event->getId() ?>" class="link">Modifier</a>
                    <a href="<?= url('planning.delete') ?>?id=<?= $event->getId() ?>" class="link">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<form class="form margin-top-40" method="<?= url("planning.index") ?>">
    <div class="form-group margin-bottom-20">
        <label for="user_id">Utilisateur</label>
        <select name="user_id" id="user_id">
            <option value="" selected>Tous les utilisateurs</option>
            <?php foreach ($staff ?? [] as $member): ?>
                <option value="<?= $member->getId() ?>"><?= htmlentities($member->getFirstName()) ?> <?= htmlentities($member->getLastName()) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <input type="submit" class="button button-black button-small display-inline" value="Filtrer le planning">
</form>

<a href="<?= url('administration') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à l'accueil de l'administration
</a>
