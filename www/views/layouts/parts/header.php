<header class="header row">
    <h4 class="col-12 col-xs-2 col-md-3 col-lg-2 header-logo">
        <a class="display-sm-none display-xs-none display-md-block" href="<?= url('administration') ?>">
            <?= htmlentities(\ESGI\Core\Configuration\Config::get('site.name')) ?>
        </a>
        <a class="display-md-none display-xs-block" href="<?= url('administration') ?>">
            <img src="/favicon.png" height="20px" width="20px" alt="Logo du site">
        </a>
    </h4>

    <?php if (\ESGI\Core\Auth\Auth::isLogged() && \ESGI\Core\Auth\Auth::getUser()->getGroup() !== null): ?>
        <div class="col-xs-1 sidebar-button display-md-none display-xs-block margin-right-10">
            <button class="header-menu" id="sidebar-button"><?= icon('menu') ?></button>
        </div>

        <form class="col-6 header-search" action="<?= url('administration.search') ?>" method="get">
            <div class="header-search-wrapper">
                <input type="text" name="search" id="search" placeholder="Recherche"
                       aria-label="Recherche" value="<?= $search ?? '' ?>">
                <button class="display-sm-none display-xs-none display-md-block" type="submit">Rechercher</button>
                <button class="display-md-none" type="submit"><?= icon('search') ?></button>
            </div>
        </form>
    <?php endif; ?>

    <div class="col-3 col-xs-1 header-user">
        <?php if (\ESGI\Core\Auth\Auth::isLogged()): ?>
            <?php $loggedUser = \ESGI\Core\Auth\Auth::getUser(); ?>
            <div class="header-user-dropdown">
                <span class="header-user-name display-xs-none"><?= htmlentities($loggedUser->getFirstname()) . ' ' . htmlentities($loggedUser->getLastname()) ?></span>
                <img src="<?= $loggedUser->getAvatar() ?: '/images/default_avatar.png' ?>" class="header-user-avatar" alt="Mon profil">
                <div class="dropdown-content">
                    <a href="<?= url('users.edit') ?>?id=<?= $loggedUser->getId() ?>" class="link">Mon profil</a>
                    <a href="<?= url('auth.logout') ?>" class="link">Déconnexion</a>
                </div>
            </div>

        <?php else: ?>
            <span class="header-user-name">
                <a href="<?= url('auth.login') ?>" class="link">Connexion</a>
            </span>
        <?php endif; ?>
    </div>
</header>
