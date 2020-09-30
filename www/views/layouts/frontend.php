<!DOCTYPE html>
<html lang="fr">
<?php include 'parts/head.php'; ?>

<body class="frontend <?= 'customize-font-' . \ESGI\Core\Configuration\Config::get('site.font') ?>">
<main>
    <div class="container content-frontend full-height padding-top-0">
        <?php include dirname(__DIR__) . '/' . ($view ?? '') . '.php'; ?>
    </div>
</main>

<?php if (\ESGI\Core\Tools\App::isInDevelopmentMode()): ?>
    <?= view('parts.debug_bar') ?>
<?php endif; ?>

<script src="<?= url('homepage') ?>dist/js/app.js"></script>
</body>
</html>
