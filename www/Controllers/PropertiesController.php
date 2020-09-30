<?php

namespace ESGI\Controllers;

use ESGI\Core\Auth\Auth;
use ESGI\Core\Database\Pagination;
use ESGI\Core\Database\QueryBuilder;
use ESGI\Core\Validation\Validation;
use ESGI\Forms\PropertiesForm;
use ESGI\Models\PropertiesModel;
use ESGI\Models\UsersModel;

class PropertiesController extends Controller
{
    public function indexAction(): void
    {
        if (Auth::getUser()->getGroup() === null) {
            redirect('administration');
        }

        $queryBuilder = (new QueryBuilder)->order('id', 'desc');
        $queryBuilder = Pagination::getQuery(PropertiesModel::getTableName(), null, $queryBuilder);

        /** @var PropertiesModel[] $properties */
        $properties = PropertiesModel::fetchAll($queryBuilder);

        $this->render('properties.index', 'backend', ['properties' => $properties]);
    }

    public function addAction(): void
    {
        if (!empty($_POST)) {
            $validation = Validation::create(PropertiesForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('properties.add', 'backend', ['errors' => $validation->getErrors()]);
                return;
            }

            /** @var UsersModel $user */
            $user = Auth::getUser();

            (new PropertiesModel())
                ->setType($_POST['type'])
                ->setAddress($_POST['address'])
                ->setConstructionDate($_POST['construction_date'])
                ->setOwnerId($user->getGroupId() === null ? $user->getId() : $_POST['owner_id'])
                ->setUserId($user->getId())
                ->insert();

            redirect('properties.index');
        }

        $this->render('properties.add', 'backend', ['errors' => []]);
    }

    public function editAction(): void
    {
        if (empty($_GET['id'])) {
            redirect('administration');
        }

        /** @var PropertiesModel|null $property */
        $property = PropertiesModel::find($_GET['id']);

        /** @var UsersModel $user */
        $user = Auth::getUser();

        if (!$property || ($user->getGroup() === null && $user->getId() !== $property->getUserId())) {
            redirect('administration');
            exit();
        }

        if (!empty($_POST)) {
            $validation = Validation::create(PropertiesForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('properties.edit', 'backend', [
                    'property' => $property,
                    'errors' => $validation->getErrors()
                ]);

                return;
            }

            $property->update();
            redirect('properties.index');
        }

        $this->render('properties.edit', 'backend', [
            'property' => $property,
            'errors' => []
        ]);
    }

    public function deleteAction(): void
    {
        if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
            /** @var PropertiesModel|null $property */
            $property = PropertiesModel::find($_GET['id']);

            /** @var UsersModel $user */
            $user = Auth::getUser();

            if (!$property || ($user->getGroup() === null && $user->getId() !== $property->getUserId())) {
                redirect('administration');
            }

            PropertiesModel::delete($_GET['id']);
        }

        redirect('properties.index');
    }
}
