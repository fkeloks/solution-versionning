<?php

namespace ESGI\Controllers;

use ESGI\Core\Database\Pagination;
use ESGI\Core\Database\QueryBuilder;
use ESGI\Core\Validation\Validation;
use ESGI\Forms\StaffForm;
use ESGI\Models\EventsModel;
use ESGI\Models\StaffModel;

class StaffController extends Controller
{
    public $security = [
        'indexAction' => 'staff.index',
        'addAction' => 'staff.add',
        'editAction' => 'staff.edit',
        'deleteAction' => 'staff.delete',
    ];

    public function indexAction(): void
    {
        $queryBuilder = Pagination::getQuery(StaffModel::getTableName(), 20);
        $staff = StaffModel::fetchAll($queryBuilder);

        $this->render('staff.index', 'backend', ['staff' => $staff]);
    }

    public function addAction(): void
    {
        if (!empty($_POST)) {
            $validation = Validation::create(StaffForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('staff.add', 'backend', ['errors' => $validation->getErrors()]);
                return;
            }

            (new StaffModel)
                ->setFirstname($_POST['firstname'])
                ->setLastname($_POST['lastname'])
                ->setFunction($_POST['function'])
                ->setSalary((float)$_POST['salary'])
                ->setStatus($_POST['status'])
                ->insert();

            redirect('staff.index');
        }

        $this->render('staff.add', 'backend', ['errors' => []]);
    }

    public function editAction(): void
    {
        if (empty($_GET['id'])) {
            redirect('administration');
        }

        $staff = StaffModel::find($_GET['id']);

        if (!$staff) {
            redirect('administration');
            exit();
        }

        if (!empty($_POST)) {
            $validation = Validation::create(StaffForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('staff.edit', 'backend', [
                    'staff' => $staff,
                    'errors' => $validation->getErrors()
                ]);

                return;
            }

            $staff->update();
            redirect('staff.index');
        }

        $this->render('staff.edit', 'backend', [
            'staff' => $staff,
            'errors' => []
        ]);
    }

    public function deleteAction(): void
    {
        if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
            /** @var EventsModel[] $events */
            $events = EventsModel::fetchAll((new QueryBuilder)->where('user_id', '=', $_GET['id']));
            $eventsIds = array_map(static function ($event) {
                return $event->getId();
            }, $events);

            EventsModel::delete($eventsIds);
            StaffModel::delete($_GET['id']);
        }

        redirect('staff.index');
    }
}
