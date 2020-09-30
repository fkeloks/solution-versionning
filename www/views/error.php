<h1 class="title-4">Erreur <?= $code ?? 404 ?> - <?= $message ?? 'Page inconnue' ?></h1>

<?php if (isset($code) && $code === 403): ?>
    <a href="<?= url('auth.login') ?>" class="button button-black">
        Connexion
    </a>
<?php endif; ?>

<?php if (isset($code) && $code === 401): ?>
    <a href="<?= url('auth.logout') ?>" class="button button-black">
        Déconnexion
    </a>
<?php endif; ?>

<?php if (isset($code) && $code === 503): ?>
    <a href="/install.php" class="button button-black">
        Installer l'application
    </a>
<?php else: ?>
    <a href="<?= url('homepage') ?>" class="link link-block">
        <?= icon('back') ?>
        Retour à l'accueil
    </a>
<?php endif; ?>
