<?php

namespace ESGI\Controllers;

use ESGI\Core\Auth\Auth;
use ESGI\Core\Database\Pagination;
use ESGI\Core\Database\QueryBuilder;
use ESGI\Core\Tools\Cache;
use ESGI\Core\Upload\Types\ImageUploadType;
use ESGI\Core\Upload\Uploader;
use ESGI\Core\Validation\Validation;
use ESGI\Forms\AnnouncementsForm;
use ESGI\Forms\ReportsForm;
use ESGI\Models\AnnouncementsModel;
use ESGI\Models\BatchesModel;
use ESGI\Models\ModulesModel;
use ESGI\Models\PropertiesModel;
use ESGI\Models\UsersModel;
use ESGI\Models\ReportsModel;

class AnnouncementsController extends Controller
{
    public function indexAction(): void
    {
        if (Auth::getUser()->getGroup() === null) {
            redirect('administration');
        }

        $queryBuilder = (new QueryBuilder)
            ->join(UsersModel::getTableName(), 'user_id')
            ->join(BatchesModel::getTableName(), 'batch_id')
            ->join(PropertiesModel::getTableName(), 'property_id', 'id', '=', 'left', 'batches')
            ->order('created_at', 'desc');

        $queryBuilder = Pagination::getQuery(AnnouncementsModel::getTableName(), null, $queryBuilder);
       
//Retrieve all the annoucements
        $announcements = AnnouncementsModel::fetchAll($queryBuilder);
        $this->render('announcements.index', 'backend', ['announcements' => $announcements]);
    }

    public function publicIndexAction(): void
    {
        $queryBuilder = (new QueryBuilder)
            ->join(BatchesModel::getTableName(), 'batch_id')
            ->join(PropertiesModel::getTableName(), 'property_id', 'id', '=', 'left', 'batches')
            ->where('status', '=', 1)
            ->order('created_at', 'desc');

        if (isset($_GET['announcement_type']) && in_array($_GET['announcement_type'], ['1', '2'], true)) {
            $queryBuilder->whereRaw('AND announcements.type = ' . $_GET['announcement_type']);
        }

        if (isset($_GET['batch_type']) && in_array($_GET['batch_type'], ['1', '2'], true)) {
            $queryBuilder->whereRaw('AND batches.type = ' . $_GET['batch_type']);
        }

        if (isset($_GET['announcement_min']) && is_numeric($_GET['announcement_min']) && $_GET['announcement_min'] > 0) {
            $queryBuilder->whereRaw('AND announcements.price >= ' . $_GET['announcement_min']);
        }

        if (isset($_GET['announcement_max']) && is_numeric($_GET['announcement_max']) && $_GET['announcement_max'] < PHP_INT_MAX) {
            $queryBuilder->whereRaw('AND announcements.price <= ' . $_GET['announcement_max']);
        }

        if (isset($_GET['sort']) && in_array($_GET['sort'], ['2', '3'], true)) {
            $queryBuilder->order('price', $_GET['sort'] === '2' ? 'asc' : 'desc');
        }

        $queryBuilder = Pagination::getQuery(AnnouncementsModel::getTableName(), 12, $queryBuilder);

        /** @var AnnouncementsModel[] $announcements */
        $announcements = AnnouncementsModel::fetchAll($queryBuilder);

        $this->render('announcements.public_index', 'frontend', [
            'announcements' => $announcements,
            'announcements_count' => AnnouncementsModel::count(),
            'modules' => $this->getModules()
        ]);
    }

    public function showAction(): void
    {
        if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
            $this->publicIndexAction();
            return;
        }

        $queryBuilder = (new QueryBuilder)
            ->join(UsersModel::getTableName(), 'user_id')
            ->join(BatchesModel::getTableName(), 'batch_id')
            ->join(PropertiesModel::getTableName(), 'property_id', 'id', '=', 'left', 'batches')
            ->whereRaw('announcements.id = ' . $_GET['id']);

        /** @var UsersModel $user */
        $user = Auth::getUser();

        // If user is not admin or not even connected show only validated announces
        if ($user === null || $user->getGroupId() === null) {
            $queryBuilder->where('status', '=', 1);
        }

        $announcement = AnnouncementsModel::fetch($queryBuilder);
        if (!$announcement) {
            redirect('homepage');
        }

        $this->render('announcements.show', 'frontend', [
            'announcement' => $announcement,
            'modules' => $this->getModules()
        ]);
    }

    public function addAction(): void
    {
        if (!empty($_POST)) {
            $validation = Validation::create(AnnouncementsForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('announcements.add', 'backend', ['errors' => $validation->getErrors()]);
                return;
            }

            /** @var UsersModel $user */
            $user = Auth::getUser();
            $userId = !empty($_POST['user_id']) ? $_POST['user_id'] : $user->getId();

            // If the user creator of the announcement is an admin announcement is validated at the time else it will pend a validation
            $status = $user->getGroupId() !== null ? 1 : 0;

            if (!empty($_FILES) && !empty($_FILES['picture']) && !empty($_FILES['picture']['name'])) {
                $_POST['picture'] = Uploader::upload('picture', [ImageUploadType::class], null, null);
            } else {
                $_POST['picture'] = null;
            }

            (new AnnouncementsModel())
                ->setDescription($_POST['description'])
                ->setType((int)$_POST['type'])
                ->setPrice((float)$_POST['price'])
                ->setPicture($_POST['picture'])
                ->setUserId($userId)
                ->setBatchId($_POST['batch_id'])
                ->setStatus($status)
                ->insert();

            redirect('announcements.index');
        }

        $this->render('announcements.add', 'backend', ['errors' => []]);
    }

    public function editAction(): void
    {
        if (empty($_GET['id'])) {
            redirect('administration');
        }

        /** @var AnnouncementsModel|null $announcement */
        $announcement = AnnouncementsModel::find($_GET['id']);

        /** @var UsersModel $user */
        $user = Auth::getUser();

        if (!$announcement || ($user->getGroup() === null && $user->getId() !== $announcement->getUserId())) {
            redirect('administration');
        }

        if (!empty($_POST)) {
            // If the user creator of the announcement is an admin announcement is validated at the time else it will pend a validation
            $_POST['status'] = $user->getGroupId() !== null ? 1 : 0;

            $validation = Validation::create(AnnouncementsForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('announcements.edit', 'backend', [
                    'announcement' => $announcement,
                    'errors' => $validation->getErrors()
                ]);

                return;
            }

            if (!empty($_FILES) && !empty($_FILES['picture']) && !empty($_FILES['picture']['name'])) {
                $_POST['picture'] = Uploader::upload('picture', [ImageUploadType::class], null, null);
            }

            $announcement->update();
            redirect('announcements.index');
        }

        $this->render('announcements.edit', 'backend', [
            'announcement' => $announcement,
            'errors' => []
        ]);
    }

    public function deleteAction(): void
    {
        if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
            /** @var AnnouncementsModel|null $announcement */
            $announcement = AnnouncementsModel::find($_GET['id']);

            /** @var UsersModel $user */
            $user = Auth::getUser();

            if (!$announcement || ($user->getGroup() === null && $user->getId() !== $announcement->getUserId())) {
                redirect('administration');
            }

            /** @var ReportsModel[] $reports */
            $reports = ReportsModel::fetchAll((new QueryBuilder)->where('announcement_id', '=', $_GET['id']));
            $reportsIds = array_map(static function ($report) {
                return $report->getId();
            }, $reports);

            ReportsModel::delete($reportsIds);
            AnnouncementsModel::delete($_GET['id']);
        }

        redirect('announcements.index');
    }

    public function reportAction(): void
    {
        // The following informations are needed to make a suitable frontend report page with the footer and header
        if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
            redirect('homepage');
        }

        $queryBuilder = (new QueryBuilder)
            ->join(BatchesModel::getTableName(), 'batch_id')
            ->join(PropertiesModel::getTableName(), 'property_id', 'id', '=', 'left', 'batches')
            ->whereRaw('announcements.id = ' . $_GET['id']);

        /** @var AnnouncementsModel|null $announcement */
        $announcement = AnnouncementsModel::fetch($queryBuilder);
        if (!$announcement) {
            redirect('homepage');
        }

        // True if the user has already reported this ad, false otherwise
        $userHasReport = $this->userHasReport($announcement);

        if (!empty($_POST) && isset($_POST['reason']) && !$userHasReport) {
            $validation = Validation::create(ReportsForm::class)->validate();
            if ($validation->hasErrors()) {
                $this->render('announcements.report', 'frontend', [
                    'errors' => $validation->getErrors(),
                    'announcement' => $announcement,
                    'modules' => $this->getModules(),
                    'message' => ''
                ]);

                return;
            }

            // We only save if it is unique
            (new ReportsModel())
                ->setReason($_POST['reason'])
                ->setAnnouncementId($_GET['id'])
                ->setClientIP($_SERVER['REMOTE_ADDR'])
                ->insert();

            header('Location: ' . url('announcements.show') . '/' . $announcement->getId());
            exit();
        }

        $this->render('announcements.report', 'frontend', [
            'announcement' => $announcement,
            'modules' => $this->getModules(),
            'errors' => [],
            'message' => $userHasReport ? 'Vous avez déjà signalé cette annonce.' : ''
        ]);
    }

    public function reportsAction(): void
    {
        if (Auth::getUser()->getGroup() === null) {
            redirect('administration');
        }

        $queryBuilder = (new QueryBuilder)
            ->join(AnnouncementsModel::getTableName(), 'announcement_id')
            ->orderRaw('reports.created_at DESC');

        $queryBuilder = Pagination::getQuery(ReportsModel::getTableName(), null, $queryBuilder);
        $reports = ReportsModel::fetchAll($queryBuilder);

        $this->render('announcements.reports', 'backend', ['reports' => $reports]);
    }

    /**
     * @return ModulesModel[]
     */
    private function getModules(): array
    {
        return Cache::remember('modules', static function () {
            $queryBuilder = (new QueryBuilder)
                ->where('locked', '=', true)
                ->order('order');

            return ModulesModel::fetchAll($queryBuilder);
        });
    }

    /**
     * Verify if a user has already reported this announce he/she is trying to report
     *
     * @param AnnouncementsModel $announcement
     *
     * @return bool
     */
    private function userHasReport(AnnouncementsModel $announcement): bool
    {
        $queryBuilder = (new QueryBuilder)
            ->where('client_ip', '=', $_SERVER['REMOTE_ADDR'])
            ->where('announcement_id', '=', $announcement->getId());

        /** @var ReportsModel[]|null $reports */
        $reported = ReportsModel::fetch($queryBuilder);

        return $reported instanceof ReportsModel;
    }
}
