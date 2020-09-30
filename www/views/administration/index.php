<?php /** @var \ESGI\Models\EventsModel[] $events */ ?>
<?php /** @var \ESGI\Models\ReportsModel[] $reports */ ?>
<?php /** @var \ESGI\Models\AnnouncementsModel[] $announcements */ ?>
<?php /** @var array $statistics */ ?>

<h1 class="title-4">Accueil de l'administration</h1>

<div class="row">
    <?php foreach ($statistics ?? [] as $label => $count): ?>
        <div class="col-12 col-md-3 text-center">
            <div class="card">
                <h5 class="card-title title-5">
                    <?= $label ?>
                    <span class="display-block margin-top-20"><?= $count ?></span>
                </h5>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row">
    <div class="col-12 col-md-6 margin-bottom-20">
        <table class="table">
            <thead>
            <tr>
                <th colspan="3">Annonces signalées</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($reports ?? [] as $report): ?>
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
            </tbody>
        </table>
    </div>

    <div class="col-12 col-md-6 margin-bottom-20">
        <table class="table">
            <thead>
            <tr>
                <th colspan="2">Annonces en attente de validation</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($announcements ?? [] as $announcement): ?>
                <tr>
                    <td>
                        <a href="<?= url('announcements.show') ?>/<?= $announcement->getId() ?>" class="link" target="_blank">
                            Annonce n°<?= $announcement->getId() ?>
                        </a>
                    </td>
                    <td class="cell-right">
                        <a href="<?= url('announcements.edit') ?>?id=<?= $report->getAnnouncementId() ?>" class="link">
                            Administrer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="col-12">
        <table class="table">
            <thead>
            <tr>
                <th colspan="2">Évènements à venir</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($events ?? [] as $event): ?>
                <tr>
                    <td><?= htmlentities($event->getName()) ?> | <?= $event->getDateStart() ?> <?= $event->getTimeStart() ?></td>
                    <td class="cell-right">
                        <a href="<?= url('planning.edit') ?>?id=<?= $event->getId() ?>" class="link">
                            Administrer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
