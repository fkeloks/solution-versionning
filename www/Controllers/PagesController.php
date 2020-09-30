<?php

namespace ESGI\Controllers;

use ESGI\Core\Configuration\Config;
use ESGI\Core\Database\Pagination;
use ESGI\Core\Database\QueryBuilder;
use ESGI\Core\Tools\Cache;
use ESGI\Core\Validation\Validation;
use ESGI\Forms\PagesForm;
use ESGI\Models\ModulesModel;
use ESGI\Models\PagesModel;

class PagesController extends Controller
{
    public $security = [
        'indexAction' => 'pages.index',
        'addAction' => 'pages.add',
        'editAction' => 'pages.edit',
        'deleteAction' => 'pages.delete',
    ];

    public function indexAction(): void
    {
        $queryBuilder = Pagination::getQuery(PagesModel::getTableName());
        $pages = PagesModel::fetchAll($queryBuilder);

        $this->render('pages.index', 'backend', ['pages' => $pages]);
    }

    public function addAction(): void
    {
        if (!empty($_POST)) {
            $validation = Validation::create(PagesForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('pages.add', 'backend', ['errors' => $validation->getErrors()]);
                return;
            }

            // Unique URLS
            /** @var PagesModel[] $pages */
            $pages = PagesModel::fetchAll();
            foreach ($pages as $page) {
                if ($page->getPath() === $_POST['path']) {
                    $this->render('pages.add', 'backend', ['errors' => ['Le chemin de la page doit être unique.']]);
                    return;
                }
            }

            (new PagesModel)
                ->setTitle(htmlentities($_POST['title']))
                ->setPath($_POST['path'])
                ->setStatus($_POST['status'])
                ->setDescription(htmlentities($_POST['description'] ?? null))
                ->insert();

            redirect('pages.index');
        }

        $this->render('pages.add', 'backend', ['errors' => []]);
    }

    public function editAction(): void
    {
        if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
            redirect('administration');
        }

        $page = PagesModel::find($_GET['id']);

        if (!$page) {
            redirect('administration');
            exit();
        }

        $query = (new QueryBuilder)
            ->from(ModulesModel::getTableName())
            ->where('page_id', '=', $_GET['id'])
            ->order('order');

        /** @var ModulesModel[] $modules */
        $modules = ModulesModel::fetchAll($query);

        if (!empty($_GET['add-module'])) {
            foreach (Config::get('modules', []) as $module => $configuration) {
                if ($module === $_GET['add-module']) {
                    $content = [];
                    foreach ($configuration['inputs'] ?? [] as $input) {
                        $content[$input['name']] = '';
                    }

                    if (isset($configuration['iterable'])) {
                        $content = [$configuration['iterable']['key'] => [$content]];
                    }

                    (new ModulesModel)
                        ->setName($module)
                        ->setOrder(100)
                        ->setPageId($_GET['id'])
                        ->setContent($content)
                        ->insert();
                }
            }

            redirect('pages.edit', ['id' => $page->getId()]);
        }

        if (!empty($_GET['remove-module'])) {
            ModulesModel::delete($_GET['remove-module']);

            redirect('pages.edit', ['id' => $page->getId()]);
        }

        if (!empty($_POST)) {
            if (!empty($_GET['module']) && is_numeric($_GET['module'])) {
                /** @var int $moduleIdentifier */
                $moduleIdentifier = $_GET['module'];

                /** @var ModulesModel|null $module */
                $module = ModulesModel::find($moduleIdentifier);

                if (!$module) {
                    redirect('pages.index');
                    exit();
                }

                $configuration = $module->getConfiguration();
                $inputs = [];

                foreach ($_POST as $key => $value) {
                    preg_match('/^field-\d+-(?<name>.*)-(?<index>\d+)$/m', $key, $matches);
                    if (!empty($matches) && isset($matches['name'])) {
                        $value = $value === '' ? null : $value;

                        if (!empty($configuration['iterable'])) {
                            if (!isset($inputs[$configuration['iterable']['key']])) {
                                $inputs[$configuration['iterable']['key']] = [];
                            }

                            $inputs[$configuration['iterable']['key']][$matches['index']][$matches['name']] = $value;
                        } else {
                            $inputs[$matches['name']] = $value;
                        }
                    }
                }

                $inputs = array_map(static function ($input) {
                    return is_array($input) ? array_values($input) : $input;
                }, $inputs);

                $module->setContent($inputs)->update(false);
                Cache::forget('modules');

                redirect('pages.edit', ['id' => $page->getId()]);
            } else {
                $validation = Validation::create(PagesForm::class)->validate();

                if ($validation->hasErrors()) {
                    $this->render('pages.edit', 'backend', [
                        'page' => $page,
                        'modules' => $modules,
                        'errors' => $validation->getErrors()
                    ]);

                    return;
                }

                $page->update();
                Cache::forget('sitemap');

                redirect('pages.index');
            }
        }

        $this->render('pages.edit', 'backend', [
            'page' => $page,
            'modules' => $modules,
            'errors' => []
        ]);
    }

    public function deleteAction(): void
    {
        PagesModel::delete($_GET['id']);

        redirect('pages.index');
    }
}
