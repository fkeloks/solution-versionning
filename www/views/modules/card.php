<?php /** @var \ESGI\Models\ModulesModel $module */ ?>

<div class="row cards-wrapper">
    <?php foreach ($module->getContent()['cards'] ?? [] as $card): ?>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <?php preg_match('/<img[^>]+src="([^">]+)"/m', $card['image'] ?? '', $imageSrc) ?>
                <?php if (is_array($imageSrc) && isset($imageSrc[1])): ?>
                    <img class="card-image" src="<?= htmlentities($imageSrc[1]) ?>" alt="<?= htmlentities($card['title']) ?? '' ?>">
                <?php endif; ?>
                <h3 class="card-title title-4"><?= htmlentities($card['title']) ?? '' ?></h3>
                <div class="card-text"><?= $card['text'] ?? '' ?></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
