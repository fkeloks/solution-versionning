<!DOCTYPE html>
<html lang="fr">
<?php include 'parts/head.php'; ?>

<body class="full-height background-gray-6">
<main>
    <div class="row flex-direction-column-reverse flex-direction-md-row overflow-hidden background-gray-6">
        <div class="col-12 col-md-6 min-height-md-full padding-20 padding-bottom-100 padding-md-100">
            <?php include dirname(__DIR__) . '/' . ($view ?? '') . '.php'; ?>
        </div>
        <div class="col-12 col-md-6 min-height-md-full padding-20 padding-md-100 background-blue-1">
            <h1 class="title-1 color-white">
                <?= ESGI\Core\Configuration\Config::get('site.name', 'EfysImmobilier') ?>
            </h1>
        </div>
    </div>
</main>

<?php if (\ESGI\Core\Tools\App::isInDevelopmentMode()): ?>
    <?= view('parts.debug_bar') ?>
<?php endif; ?>

<script src="<?= url('homepage') ?>dist/js/app.js"></script>
</body>
</html>
