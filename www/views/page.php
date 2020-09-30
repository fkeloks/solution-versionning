<?php /** @var \ESGI\Models\PagesModel $page */ ?>
<?php /** @var \ESGI\Models\ModulesModel[] $modules */ ?>

<?php foreach ($modules as $module): ?>
    <?php $modulePath = __DIR__ . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $module->getName() . '.php' ?>
    <?php if (file_exists($modulePath)): ?>
        <?php include $modulePath; ?>
    <?php endif; ?>
<?php endforeach; ?>
