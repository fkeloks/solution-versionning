<?php
/** @var string $search */
/** @var int $count */
/** @var ESGI\Models\PropertiesModel[] $properties */
/** @var ESGI\Models\OwnersModel[] $owners */
/** @var ESGI\Models\PagesModel[] $pages */
/** @var ESGI\Models\AnnouncementsModel[] $announcements */
/** @var ESGI\Models\EventsModel[] $events */
/** @var ESGI\Models\GroupsModel[] $groups */
/** @var ESGI\Models\StaffModel[] $staff */
/** @var ESGI\Models\UsersModel[] $users */
?>

<h1 class="title-4">Recherche "<?= $search ?>"</h1>
<p class="title-5"><?= $count ?> résultat<?= $count > 1 ? 's' : '' ?></p>
<hr class="normal-margin">

<?php if (count($properties)): ?>
    <h2 class="title-5">Propriétés</h2>
    <?= view('parts/tables/properties', ['properties' => $properties]) ?>
<?php endif; ?>

<?php if (count($owners)): ?>
    <h2 class="title-5 margin-top-40">Propriétaires</h2>
    <?= view('parts/tables/owners', ['owners' => $owners]) ?>
<?php endif; ?>

<?php if (count($pages)): ?>
    <h2 class="title-5 margin-top-40">Pages</h2>
    <?= view('parts/tables/pages', ['pages' => $pages]) ?>
<?php endif; ?>

<?php if (count($announcements)): ?>
    <h2 class="title-5 margin-top-40">Annonces</h2>
    <?= view('parts/tables/announcements', ['announcements' => $announcements]) ?>
<?php endif; ?>

<?php if (count($events)): ?>
    <h2 class="title-5 margin-top-40">Evenements</h2>
    <?= view('parts/tables/events', ['events' => $events]) ?>
<?php endif; ?>

<?php if (count($groups)): ?>
    <h2 class="title-5 margin-top-40">Groupes</h2>
    <?= view('parts/tables/groups', ['groups' => $groups]) ?>
<?php endif; ?>

<?php if (count($staff)): ?>
    <h2 class="title-5 margin-top-40">Staff</h2>
    <?= view('parts/tables/staff', ['staff' => $staff]) ?>
<?php endif; ?>

<?php if (count($users)): ?>
    <h2 class="title-5 margin-top-40">Utilisateurs</h2>
    <?= view('parts/tables/users', ['users' => $users]) ?>
<?php endif; ?>

<a href="<?= url('administration') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à l'accueil de l'administration
</a>
