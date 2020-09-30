<!DOCTYPE html>
<html lang="fr">
<?php include 'parts/head.php'; ?>

<body class="background-gray-6">
<main>
    <?php include 'parts/header.php'; ?>

    <?php

    use \ESGI\Core\Auth\Auth;

    ?>

    <?php if (!Auth::isLogged() || (Auth::isLogged() && Auth::getUser()->getGroup() === null)): ?>
        <div class="content">
            <?php include dirname(__DIR__) . '/' . ($view ?? '') . '.php'; ?>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-12 col-md-3 col-lg-2 background-white">
                <?php include 'parts/sidebar.php'; ?>
            </div>
            <div class="col-12 col-md-9 col-lg-10 content background-gray-6">
                <?php include dirname(__DIR__) . '/' . ($view ?? '') . '.php'; ?>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php if (\ESGI\Core\Tools\App::isInDevelopmentMode()): ?>
    <?= view('parts.debug_bar') ?>
<?php endif; ?>

<script src="<?= url('homepage') ?>dist/js/app.js"></script>
</body>
</html>
