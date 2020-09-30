<?php

namespace ESGI\Controllers;

use ESGI\Core\Auth\Auth;
use ESGI\Core\Database\Pagination;
use ESGI\Core\Database\QueryBuilder;
use ESGI\Core\Upload\Types\ImageUploadType;
use ESGI\Core\Upload\Uploader;
use ESGI\Core\Validation\Validation;
use ESGI\Forms\UsersForm;
use ESGI\Core\Security\NotAllowedException;
use ESGI\Models\GroupsModel;
use ESGI\Models\UsersModel;

class UsersController extends Controller
{
    public $security = [
        'indexAction' => 'users.index',
        'addAction' => 'users.add',
        'deleteAction' => 'users.delete',
    ];

    public function indexAction(): void
    {
        $queryBuilder = (new QueryBuilder)->join(GroupsModel::getTableName(), 'group_id')->order('lastname');
        $queryBuilder = Pagination::getQuery(UsersModel::getTableName(), 20, $queryBuilder);

        /** @var UsersModel[] $users */
        $users = UsersModel::fetchAll($queryBuilder);

        $this->render('users.index', 'backend', ['users' => $users]);
    }

    public function addAction(): void
    {
        if (!empty($_POST)) {
            $validation = Validation::create(UsersForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('users.add', 'backend', ['errors' => $validation->getErrors()]);
                return;
            }

            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            (new UsersModel)
                ->setLastname($_POST['lastname'])
                ->setFirstname($_POST['firstname'])
                ->setEmail($_POST['email'])
                ->setGroupId($_POST['group_id'] ? (int)$_POST['group_id'] : null)
                ->setPassword($password)
                ->insert();

            redirect('users.index');
        }

        $this->render('users.add', 'backend', ['errors' => []]);
    }

    public function editAction(): void
    {
        if (empty($_GET['id'])) {
            redirect('administration');
        }

        /** @var UsersModel $user */
        $user = Auth::getUser();
        $publicProfile = $user->getGroup() === null;
        if ($publicProfile && $user->getId() !== (int)$_GET['id']) {
            throw new NotAllowedException;
        }

        $queryBuilder = (new QueryBuilder)->join(GroupsModel::getTableName(), 'group_id');

        /** @var UsersModel|null $user */
        $user = UsersModel::find($_GET['id'], $queryBuilder);

        if (!$user) {
            redirect('administration');
        }

        if (!empty($_POST)) {
            $validation = Validation::create(UsersForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('users.edit', 'backend', [
                    'user' => $user,
                    'errors' => $validation->getErrors()
                ]);

                return;
            }

            if (!empty($_FILES) && !empty($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
                if ($user->getAvatar() !== null) {
                    $path = Uploader::getUploadPath('avatars') . basename($user->getAvatar());
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }

                $_POST['avatar'] = Uploader::upload('avatar', [ImageUploadType::class], 'avatars', $_GET['id']);
            }

            if ($user instanceof UsersModel && !empty($_POST['password'])) {
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $user->update();
            } else {
                $user->update(true, ['password']);
            }

            if (($_POST['username'] || $_POST['firstname'] || $_POST['email']) && Auth::getUser()->getId() === $user->getId()) {
                Auth::login($user);
            }

            redirect($publicProfile ? 'administration' : 'users.index');
        }

        $this->render('users.' . ($publicProfile ? 'profile' : 'edit'), 'backend', [
            'user' => $user,
            'errors' => []
        ]);
    }

    public function deleteAction(): void
    {
        if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
            UsersModel::delete($_GET['id']);
        }

        redirect('users.index');
    }
}
