<?php

namespace ESGI\Controllers;

use ESGI\Core\Database\Pagination;
use ESGI\Forms\OwnersForm;
use ESGI\Models\OwnersModel;
use ESGI\Core\Validation\Validation;

class OwnersController extends Controller
{
    public $security = [
        'indexAction' => 'owners.index',
        'addAction' => 'owners.add',
        'editAction' => 'owners.edit',
        'deleteAction' => 'owners.delete',
    ];

    public function indexAction(): void
    {
        $queryBuilder = Pagination::getQuery(OwnersModel::getTableName());
        $owners = OwnersModel::fetchAll($queryBuilder);

        $this->render('owners.index', 'backend', ['owners' => $owners]);
    }

    public function addAction(): void
    {
        if (!empty($_POST)) {
            $validation = Validation::create(OwnersForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('owners.add', 'backend', ['errors' => $validation->getErrors()]);
                return;
            }

            (new OwnersModel)
                ->setLastName($_POST['lastname'])
                ->setFirstName($_POST['firstname'])
                ->setMail($_POST['mail'])
                ->setAddress($_POST['address'])
                ->setPhone($_POST['phone'])
                ->insert();

            redirect('owners.index');
        }

        $this->render('owners.add', 'backend', ['errors' => []]);
    }

    public function editAction(): void
    {
        if (empty($_GET['id'])) {
            redirect('administration');
        }

        $owner = OwnersModel::find($_GET['id']);

        if (!$owner) {
            redirect('administration');
            exit();
        }

        if (!empty($_POST)) {
            $validation = Validation::create(OwnersForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('owners.edit', 'backend', [
                    'owner' => $owner,
                    'errors' => $validation->getErrors()
                ]);

                return;
            }

            $owner->update();
            redirect('owners.index');
        }

        $this->render('owners.edit', 'backend', [
            'owner' => $owner,
            'errors' => []
        ]);
    }

    public function deleteAction(): void
    {
        OwnersModel::delete($_GET['id']);

        redirect('owners.index');
    }
}
