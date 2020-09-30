<?php

namespace ESGI\Controllers;

use ESGI\Core\Database\Database;
use ESGI\Core\Database\QueryBuilder;
use ESGI\Core\Validation\Validation;
use ESGI\Forms\GroupsForm;
use ESGI\Models\GroupsModel;
use ESGI\Models\GroupsPermissionsModel;
use ESGI\Models\PermissionsModel;

class GroupsController extends Controller
{
    public $security = [
        'indexAction' => 'groups.index',
        'addAction' => 'groups.add',
        'editAction' => 'groups.edit',
        'deleteAction' => 'groups.delete',
    ];

    public function indexAction(): void
    {
        /** @var GroupsModel[] $groups */
        $groups = GroupsModel::fetchAll();

        $this->render('groups.index', 'backend', ['groups' => $groups]);
    }

    public function addAction(): void
    {
        if (!empty($_POST)) {
            $validation = Validation::create(GroupsForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('groups.add', 'backend', ['errors' => $validation->getErrors()]);
                return;
            }

            (new GroupsModel)
                ->setName($_POST['name'])
                ->insert();

            redirect('groups.index');
        }

        $this->render('groups.add', 'backend', ['errors' => []]);
    }

    public function editAction(): void
    {
        if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
            redirect('administration');
        }

        /** @var GroupsModel $group */
        $group = GroupsModel::find($_GET['id']);

        if (!$group) {
            redirect('administration');
        }

        if (!empty($_POST)) {
            $validation = Validation::create(GroupsForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('groups.edit', 'backend', [
                    'group' => $group,
                    'errors' => $validation->getErrors()
                ]);

                return;
            }

            $group->update();

            if (!empty($_POST['permissions']) && is_array($_POST['permissions'])) {
                $pdo = Database::getPdo();
                $pdo->exec('DELETE FROM `groups_permissions` WHERE `group_id` = \'' . $group->getId() . '\';');

                $sql = 'INSERT INTO `groups_permissions` (`group_id`, `permission_id`) VALUES';
                $lastKey = array_keys($_POST['permissions'])[count($_POST['permissions']) - 1];

                foreach ($_POST['permissions'] as $permissionId => $value) {
                    $sql .= '(\'' . $group->getId() . '\', \'' . $permissionId . '\')';

                    if ($permissionId === $lastKey) {
                        $sql .= ';';
                    } else {
                        $sql .= ', ';
                    }
                }

                $pdo->exec($sql);
            }

            redirect('groups.index');
        }

        $queryBuilder = (new QueryBuilder)
            ->join(GroupsModel::getTableName(), 'group_id')
            ->join(PermissionsModel::getTableName(), 'permission_id')
            ->where('group_id', '=', $group->getId());

        /** @var GroupsPermissionsModel[] $groupPermissions */
        $groupPermissions = GroupsPermissionsModel::fetchAll($queryBuilder);
        $permissions = array_map(static function (GroupsPermissionsModel $groupPermission) {
            return $groupPermission->getPermission();
        }, $groupPermissions);

        $group->setPermissions($permissions);

        $this->render('groups.edit', 'backend', [
            'group' => $group,
            'permissions' => $permissions,
            'errors' => []
        ]);
    }

    public function deleteAction(): void
    {
        if (!empty($_GET['id']) && is_numeric($_GET['id']) && (int)$_GET['id'] !== 1) {
            $queryBuilder = (new QueryBuilder)->where('group_id', '=', $_GET['id']);

            /** @var GroupsPermissionsModel[] $groupPermissions */
            $groupPermissions = GroupsPermissionsModel::fetchAll($queryBuilder);
            $permissionsIds = array_map(static function ($permission) {
                return $permission->getId();
            }, $groupPermissions);

            GroupsPermissionsModel::delete($permissionsIds);
            GroupsModel::delete($_GET['id']);
        }

        redirect('groups.index');
    }
}
