<?php

namespace ESGI\Controllers;

use ESGI\Core\Database\QueryBuilder;
use ESGI\Models\ModulesModel;
use ESGI\Models\PagesModel;

class DefaultController extends Controller
{
    public function administrationAction(): void
    {
        $this->render('administration', 'backend');
    }

    public function pageAction(): void
    {
        $path = $_SERVER['REQUEST_URI'] ?? null;
        if (!$path) {
            $this->errorAction();
        }

        $page = $this->getPage($path);
        $modules = $this->getPageModules($page->getId());

        $this->render('page', 'frontend', [
            'page' => $page,
            'modules' => $modules
        ]);
    }

    private function getPage(string $path): PagesModel
    {
        $queryBuilder = (new QueryBuilder)
            ->where('path', '=', preg_quote($path, null))
            ->where('status', '=', PagesModel::STATUS_PUBLISHED);

        /** @var PagesModel|null $page */
        $page = PagesModel::fetch($queryBuilder);

        if (!$page) {
            $this->errorAction();
            exit();
        }

        return $page;
    }

    /**
     * @param int $pageId
     *
     * @return ModulesModel[]
     */
    private function getPageModules(int $pageId): array
    {
        $queryBuilder = (new QueryBuilder)
            ->from(ModulesModel::getTableName())
            ->where('page_id', '=', $pageId)
            ->where('page_id', 'is', null, 'or')
            ->order('order');

        /** @var ModulesModel[] $modules */
        $modules = ModulesModel::fetchAll($queryBuilder);

        return $modules;
    }

    /**
     * Show an error
     *
     * @param int $code
     * @param string $message
     */
    public function errorAction(int $code = 404, string $message = 'Page inconnue'): void
    {
        http_response_code($code);

        $this->render('error', 'basic', [
            'code' => $code,
            'message' => $message
        ]);

        exit();
    }
}
