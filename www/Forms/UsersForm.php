<?php

namespace ESGI\Forms;

use ESGI\Core\Auth\Auth;
use ESGI\Core\Database\QueryBuilder;
use ESGI\Core\Forms\FormInterface;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;
use ESGI\Models\GroupsModel;
use ESGI\Models\UsersModel;

class UsersForm implements FormInterface
{
    public static function getConfiguration(?ModelInterface $model = null): array
    {
        return [
            'class' => 'form',
            'action' => url('users.' . ($model === null ? 'add' : 'edit')),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ];
    }

    public static function getInputs(?ModelInterface $model = null): array
    {
        $inputs = [
            Input::text('firstname', $model, ['label' => 'Prénom']),
            Input::text('lastname', $model, ['label' => 'Nom']),
            Input::email('email', $model, ['label' => 'Email']),
            Input::password('password', $model, ['label' => 'Mot de passe', 'required' => false]),
            Input::file('avatar', $model, [
                'label' => 'Photo de profil',
                'required' => false,
                'accept' => '.jpg, .jpeg, .png'
            ]),
        ];

        /** @var UsersModel $user */
        $user = Auth::getUser();

        if ($user->getGroupId() !== null) {
            $queryBuilder = null;
            if ($user->getGroupId() !== 1) {
                $queryBuilder = (new QueryBuilder)->where('id', '!=', 1);
            }

            /** @var GroupsModel[] $groups */
            $groups = GroupsModel::fetchAll($queryBuilder);
            $inputs[] = Input::relation('group_id', $groups, 'name', $model, [
                'label' => 'Groupe',
                'nullable' => 'Aucun groupe'
            ]);
        }

        $inputs[] = Input::submit(($model === null ? 'Ajouter' : 'Modifier'), ['class' => 'button button-black']);

        return $inputs;
    }

    public static function getRules(): array
    {
        $rules = [
            'firstname' => ['required', 'min:2', 'max:50'],
            'lastname' => ['required', 'min:2', 'max:100'],
            'email' => ['required', 'email'],
            'password' => array_merge((isset($_GET['id']) ? ['nullable'] : []), ['min:4']),
            'avatar' => ['nullable']
        ];

        if (Auth::getUser()->getGroup() !== null) {
            $rules['group_id'] = [];
        }

        return $rules;
    }

    public static function getLabels(): array
    {
        $labels = [
            'firstname' => 'prénom',
            'lastname' => 'nom',
            'email' => 'email',
            'password' => 'mot de passe',
        ];

        if (Auth::getUser()->getGroup() !== null) {
            $labels['group_id'] = 'groupe';
        }

        return $labels;
    }
}
