<?php /** @var \ESGI\Models\ModulesModel[] $modules */ ?>

<h3 class="title-4">Gestion de l'apparence du site</h3>
<p class="margin-bottom-20">
    Ces modules sont présents sur toutes les pages du site. Ils peuvent êtres modifiés mais ne peuvent pas être
    supprimés.
</p>

<div class="form">
    <?php foreach ($modules as $module): ?>
        <div class="card full-width">
            <div class="card-title title-5"><?= $module->getConfiguration()['label'] ?? $module->getName() ?></div>
            <div class="card-text">
                <?php if (!empty($module->getConfiguration()['inputs'])): ?>
                    <form class="form" action="<?= url('appearance.edit') ?>?module=<?= $module->getId() ?>" method="post">
                        <?php
                        $configuration = $module->getConfiguration();
                        $content = $module->getContent();
                        $iterable = !empty($configuration['iterable']);
                        $fieldInstances = $iterable ? $content[$configuration['iterable']['key']] : [$content];
                        ?>
                        <?php foreach ($fieldInstances as $index => $fieldInstance): ?>
                            <fieldset>
                                <legend><?= $index + 1 ?></legend>
                                <?php if ($iterable && count($fieldInstances) > 1): ?>
                                    <button type="button" class="button button-small button-red float-right remove-module-children margin-bottom-10">
                                        Retirer
                                    </button>
                                <?php endif; ?>
                                <?php foreach ($configuration['inputs'] as $field): ?>
                                    <?= view('parts/field', [
                                        'field' => $field,
                                        'index' => $index,
                                        'instance' => $fieldInstance
                                    ]) ?>
                                <?php endforeach; ?>
                            </fieldset>
                        <?php endforeach; ?>
                        <?php if ($iterable): ?>
                            <button type="button" class="button button-small button-blue add-module-children margin-bottom-10">
                                Ajouter un(e) <?= lcfirst($module->getConfiguration()['label'] ?? $module->getName()) ?>
                            </button>
                        <?php endif; ?>
                        <input class="button button-small button-black margin-bottom-20" type="submit" value="Mettre à jour">
                    </form>
                <?php endif; ?>

                <details>
                    <summary title="Aperçu du module configuré">Aperçu</summary>
                    <?php $modulePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $module->getName() . '.php' ?>
                    <?php if (file_exists($modulePath)): ?>
                        <div class="preview">
                            <?php include $modulePath; ?>
                        </div>
                    <?php endif; ?>
                </details>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<a href="<?= url('administration') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à l'accueil de l'administration
</a>
