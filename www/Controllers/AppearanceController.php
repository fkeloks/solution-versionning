<?php

namespace ESGI\Controllers;

use ESGI\Core\Database\QueryBuilder;
use ESGI\Core\Tools\Cache;
use ESGI\Models\ModulesModel;

class AppearanceController extends Controller
{
    public $security = ['editAction' => 'settings.edit'];

    public function editAction(): void
    {
        if (!empty($_GET['module']) && is_numeric($_GET['module'])) {
            /** @var int $moduleIdentifier */
            $moduleIdentifier = $_GET['module'];

            /** @var ModulesModel|null $module */
            $module = ModulesModel::find($moduleIdentifier);

            if ($module) {
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
                    return array_values($input);
                }, $inputs);

                $module->setContent($inputs)->update(false);
                Cache::forget('modules');

                redirect('appearance.edit');
            }
        }

        $queryBuilder = (new QueryBuilder)
            ->where('locked', '=', true)
            ->order('order');

        /** @var ModulesModel[] $modules */
        $modules = ModulesModel::fetchAll($queryBuilder);

        $this->render('appearance.edit', 'backend', ['modules' => $modules]);
    }
}
