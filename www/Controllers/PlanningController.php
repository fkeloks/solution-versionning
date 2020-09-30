<?php

namespace ESGI\Controllers;

use ESGI\Core\Validation\Validation;
use ESGI\Forms\EventsForm;
use ESGI\Models\EventsModel;
use ESGI\Core\Database\QueryBuilder;
use ESGI\Models\StaffModel;

class PlanningController extends Controller
{
    public $security = [
        'indexAction' => 'events.index',
        'addAction' => 'events.add',
        'editAction' => 'events.edit',
        'deleteAction' => 'events.delete',
    ];

    public function indexAction(): void
    {
        /** @var StaffModel[] $staff */
        $staff = StaffModel::fetchAll();

        $queryBuilder = (new QueryBuilder)->join(StaffModel::getTableName(), 'user_id')->order('date_start');
        if (!empty($_GET) && isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
            $queryBuilder = $queryBuilder->where('user_id', '=', $_GET['user_id']);
        }

        /** @var EventsModel[] $events */
        $events = EventsModel::fetchAll($queryBuilder);

        $this->render('planning.index', 'backend', [
            'staff' => $staff,
            'events' => $events
        ]);
    }

    public function addAction(): void
    {
        if (!empty($_POST)) {
            $validation = Validation::create(EventsForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('planning.add', 'backend', ['errors' => $validation->getErrors()]);
                return;
            }

            (new EventsModel)
                ->setUserId($_POST['user_id'] ?? null)
                ->setType($_POST['type'])
                ->setName($_POST['name'])
                ->setDateStart($_POST['date_start'])
                ->setDateEnd($_POST['date_end'])
                ->setTimeStart($_POST['time_start'])
                ->setTimeEnd($_POST['time_end'])
                ->insert();

            redirect('planning.index');
        }

        $this->render('planning.add', 'backend', ['errors' => []]);
    }

    public function editAction(): void
    {
        if (empty($_GET['id'])) {
            redirect('administration');
        }

        $event = EventsModel::find($_GET['id']);

        if (!$event) {
            redirect('administration');
            exit();
        }

        if (!empty($_POST)) {
            $validation = Validation::create(EventsForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('planning.edit', 'backend', [
                    'event' => $event,
                    'errors' => $validation->getErrors()
                ]);

                return;
            }

            $event->update();
            redirect('planning.index');
        }

        $this->render('planning.edit', 'backend', [
            'event' => $event,
            'errors' => []
        ]);
    }

    public function deleteAction(): void
    {
        EventsModel::delete($_GET['id']);

        redirect('planning.index');
    }
}
