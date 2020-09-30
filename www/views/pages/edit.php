<?php

use ESGI\Core\Configuration\Config;
use ESGI\Models\ModulesModel;
use ESGI\Models\PagesModel;

/** @var PagesModel $page */
/** @var ModulesModel[] $modules */
/** @var string[] $errors */
?>

<a href="<?= $page->getPath() ?>" class="link link-float-right">Accès à la page</a>
<h1 class="title-4">Edition de la page n°<?= $page->getId() ?> - <?= htmlentities($page->getTitle()) ?></h1>

<?= view('parts/errors', ['errors' => $errors]) ?>

<?= form('pages', $page) ?>

<hr>

<h3 class="title-5">Gestion des modules</h3>
<div class="form">
    <?php foreach ($modules as $module): ?>
        <div class="card full-width">
            <div class="card-title"><?= $module->getConfiguration()['label'] ?? $module->getName() ?></div>
            <div class="card-text">
                <?php if (!empty($module->getConfiguration()['inputs'])): ?>
                    <form class="form"
                          action="<?= url('pages.edit') ?>?id=<?= $page->getId() ?>&module=<?= $module->getId() ?>"
                          method="post">
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
                                    <button type="button"
                                            class="button button-small button-red float-right remove-module-children margin-bottom-10">
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
                        <input class="button button-small button-black margin-bottom-20" type="submit"
                               value="Mettre à jour">
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

                <div class="row">
                    <div class="col-12 col-md-7 margin-top-20">
                        <div class="form-group">
                            <label for="order" class="display-inline">Ordre d'affichage :</label>
                            <input class="input-small min-width-unset" type="number" name="order" id="order" min="1"
                                   max="999999" value="<?= $module->getOrder() ?>" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-5 text-right margin-top-20">
                        <a href="<?= url('pages.edit') ?>?id=<?= $page->getId() ?>&remove-module=<?= $module->getId() ?>"
                           class="button button-small button-red" title="Supprimer le module">
                            Supprimer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="form-group">
        <label for="add-module">Configurer un nouveau module :</label>
        <select name="add-module" id="add-module" class="display-inline">
            <?php foreach (Config::get('modules', []) as $module => $configuration): ?>
                <option value="<?= $module ?>"><?= $configuration['label'] ?? $module ?></option>
            <?php endforeach; ?>
        </select>
        <button type="button" id="add-module-button" class="button button-blue display-inline margin-top-10"
                data-url="<?= url('pages.edit') ?>?id=<?= $page->getId() ?>">
            Configurer
        </button>
    </div>
</div>

<a href="<?= url('pages.index') ?>" class="link link-block">
    <?= icon('back') ?>
    Retour à la liste des pages
</a>
