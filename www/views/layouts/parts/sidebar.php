<div class="sidebar display-xs-none display-sm-none display-md-block">
    <div class="sidebar-sections">
        <?php $currentRoute = \ESGI\Helpers\Route::getCurrentRoute() ?>
        <?php $sections = \ESGI\Core\Configuration\Config::get('sidebar')['links'] ?>
        <?php foreach ($sections as $label => $links): ?>
            <div class="sidebar-section">
                <span class="sidebar-section-title"><?= $label ?></span>
                <div class="sidebar-section-links">
                    <?php foreach ($links as $route => $link): ?>
                        <a href="<?= url($route) ?>" <?= $route === $currentRoute ? 'class="active"' : '';?> <?= $route == 'homepage' ? 'target="_blank"' : ''; ?>>
                            <?= $link ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
