<?php

namespace ESGI\Forms;

use ESGI\Core\Forms\FormInterface;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;
use ESGI\Models\GroupsModel;
use ESGI\Models\PermissionsModel;

class GroupsForm implements FormInterface
{
    public static function getConfiguration(?ModelInterface $model = null): array
    {
        return [
            'class' => 'form',
            'action' => url('groups.' . ($model === null ? 'add' : 'edit')),
            'method' => 'post'
        ];
    }

    public static function getInputs(?ModelInterface $model = null): array
    {
        $inputs = [
            Input::text('name', $model, ['label' => 'Nom du groupe', 'placeholder' => 'Ex: Modérateurs'])
        ];

        if ($model instanceof GroupsModel) {
            $groupPermissionsIds = array_map(static function (PermissionsModel $permission) {
                return $permission->getId();
            }, $model->getPermissions());

            /** @var PermissionsModel[] $permissions */
            $permissions = array_map(static function (PermissionsModel $permission) use ($groupPermissionsIds) {
                $permission->checked = in_array($permission->getId(), $groupPermissionsIds, true);

                return $permission;
            }, PermissionsModel::fetchAll());

            foreach ($permissions as $permission) {
                $input = Input::checkbox(
                    'permissions[' . $permission->getId() . ']',
                    ['label' => $permission->getName(), 'checked' => $permission->checked]
                );

                $inputs[] = $input;
            }
        }

        $inputs[] = Input::submit(($model === null ? 'Ajouter' : 'Modifier'), ['class' => 'button button-black']);

        return $inputs;
    }

    public static function getRules(): array
    {
        return ['name' => ['required', 'min:2', 'max:50']];
    }

    public static function getLabels(): array
    {
        return ['name' => 'nom du groupe'];
    }
}
