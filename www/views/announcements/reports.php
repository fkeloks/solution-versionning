<?php /** @var \ESGI\Models\ReportsModel[] $reports */ ?>

<div class="flex">
    <h1 class="title-4">Liste des signalements</h1>
</div>

<table class="table">
    <thead>
    <tr>
        <th>Annonce</th>
        <th>Signalement</th>
        <th class="cell-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($reports ?? [])): ?>
        <tr>
            <td colspan="3">Aucun signalement</td>
        </tr>
    <?php else: ?>
        <?php foreach ($reports as $report): ?>
            <tr>
                <td>
                    <a href="<?= url('announcements.show') ?>/<?= $report->getAnnouncementId() ?>" class="link" target="_blank">
                        Annonce n°<?= $report->getAnnouncementId() ?>
                    </a>
                </td>
                <td><i><?= htmlentities($report->getReason()) ?></i></td>
                <td class="cell-right">
                    <a href="<?= url('announcements.edit') ?>?id=<?= $report->getAnnouncementId() ?>" class="link">
                        Administrer
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<?= view('parts.pagination', ['table' => \ESGI\Models\ReportsModel::getTableName()]) ?>

<a href="<?= url('administration') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à l'accueil de l'administration
</a>
