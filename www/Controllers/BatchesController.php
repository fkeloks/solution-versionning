<?php

namespace ESGI\Controllers;

use ESGI\Core\Auth\Auth;
use ESGI\Core\Database\Pagination;
use ESGI\Core\Database\QueryBuilder;
use ESGI\Core\Validation\Validation;
use ESGI\Forms\BatchesForm;
use ESGI\Models\AnnouncementsModel;
use ESGI\Models\BatchesModel;
use ESGI\Models\PropertiesModel;
use ESGI\Models\ReportsModel;
use ESGI\Models\UsersModel;

class BatchesController extends Controller
{
    public function indexAction(): void
    {
        if (Auth::getUser()->getGroup() === null) {
            redirect('administration');
        }

        $queryBuilder = (new QueryBuilder)->join(PropertiesModel::getTableName(), 'property_id');
        $queryBuilder = Pagination::getQuery(BatchesModel::getTableName(), null, $queryBuilder);
        $batches = BatchesModel::fetchAll($queryBuilder);

        $this->render('batches.index', 'backend', ['batches' => $batches]);
    }

    public function addAction(): void
    {
        if (!empty($_POST)) {
            $validation = Validation::create(BatchesForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('batches.add', 'backend', ['errors' => $validation->getErrors()]);
                return;
            }

            (new BatchesModel)
                ->setNumber((int)$_POST['number'])
                ->setType($_POST['type'])
                ->setSurface((float)$_POST['surface'])
                ->setPropertyId((int)$_POST['property_id'])
                ->insert();

            redirect('batches.index');
        }

        $this->render('batches.add', 'backend', ['errors' => []]);
    }

    public function editAction(): void
    {
        if (empty($_GET['id'])) {
            redirect('administration');
        }

        $queryBuilder = (new QueryBuilder)->join(PropertiesModel::getTableName(), 'property_id');

        /** @var BatchesModel|null $batch */
        $batch = BatchesModel::find($_GET['id'], $queryBuilder);

        /** @var UsersModel $user */
        $user = Auth::getUser();

        if (!$batch || ($user->getGroup() === null && $user->getId() !== $batch->getProperty()->getUserId())) {
            redirect('administration');
        }

        if (!empty($_POST)) {
            $validation = Validation::create(BatchesForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('batches.edit', 'backend', [
                    'batch' => $batch,
                    'errors' => $validation->getErrors()
                ]);

                return;
            }

            $batch->update();
            redirect('batches.index');
        }

        $this->render('batches.edit', 'backend', [
            'batch' => $batch,
            'errors' => []
        ]);
    }

    public function deleteAction(): void
    {
        if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
            $queryBuilder = (new QueryBuilder)->join(PropertiesModel::getTableName(), 'property_id');

            /** @var BatchesModel|null $batch */
            $batch = BatchesModel::find($_GET['id'], $queryBuilder);

            /** @var UsersModel $user */
            $user = Auth::getUser();

            if (!$batch || ($user->getGroup() === null && $user->getId() !== $batch->getProperty()->getUserId())) {
                redirect('administration');
            }

            /** @var AnnouncementsModel[] $announcements */
            $announcements = AnnouncementsModel::fetchAll((new QueryBuilder)->where('batch_id', '=', $_GET['id']));
            $announcementsIds = array_map(static function ($announcement) {
                $queryBuilder = (new QueryBuilder)->where('announcement_id', '=', $announcement->getId());

                /** @var ReportsModel[] $reports */
                $reports = ReportsModel::fetchAll($queryBuilder);
                $reportsIds = array_map(static function ($report) {
                    return $report->getId();
                }, $reports);

                ReportsModel::delete($reportsIds);

                return $announcement->getId();
            }, $announcements);

            AnnouncementsModel::delete($announcementsIds);
            BatchesModel::delete($_GET['id']);
        }

        redirect('batches.index');
    }
}
