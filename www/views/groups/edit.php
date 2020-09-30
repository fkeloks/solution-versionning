<?php /** @var \ESGI\Models\GroupsModel $group */ ?>
<?php /** @var \ESGI\Models\PermissionsModel[] $permissions */ ?>
<?php /** @var string[] $errors */ ?>

<h1 class="title-4">Edition du groupe n°<?= $group->getId() ?></h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('groups', $group) ?>

<a href="<?= url('groups.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des groupes
</a>
