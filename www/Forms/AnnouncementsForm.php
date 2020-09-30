<?php

namespace ESGI\Forms;

use ESGI\Core\Auth\Auth;
use ESGI\Core\Database\QueryBuilder;
use ESGI\Core\Forms\FormInterface;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;
use ESGI\Models\AnnouncementsModel;
use ESGI\Models\BatchesModel;
use ESGI\Models\PropertiesModel;
use ESGI\Models\UsersModel;

class AnnouncementsForm implements FormInterface
{
    public static function getConfiguration(?ModelInterface $model = null): array
    {
        return [
            'class' => 'form',
            'action' => url('announcements.' . ($model === null ? 'add' : 'edit')),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ];
    }

    public static function getInputs(?ModelInterface $model = null): array
    {
        $queryBuilder = (new QueryBuilder)
            ->join(PropertiesModel::getTableName(), 'property_id')
            ->order('number', 'asc');

        /** @var UsersModel $user */
        $user = Auth::getUser();
        if ($user->getGroup() === null) {
            $queryBuilder->where('user_id', '=', $user->getId());
        }

        /** @var BatchesModel[] $batches */
        $batches = BatchesModel::fetchAll($queryBuilder);

        $inputs = [
            Input::relation('batch_id', $batches, static function (BatchesModel $batch) {
                return BatchesModel::TYPES[$batch->getType()] . ' - n°' . $batch->getNumber() . ' (' . $batch->getSurface() . ' m<sup>2</sup>)';
            }, $model, ['label' => 'Lot']),
            Input::file('picture', $model, [
                'label' => 'Image',
                'required' => false,
                'accept' => '.jpg, .jpeg, .png'
            ]),
            Input::select('type', $model, ['label' => 'Type'], AnnouncementsModel::TYPES),
            Input::wysiwyg('description', $model, ['label' => 'Description']),
            Input::number('price', $model, ['label' => 'Prix', 'step' => 0.1])
        ];

        if ($user->getGroup() !== null) {
            $inputs[] = Input::relation('user_id', UsersModel::class, static function (UsersModel $user) {
                return $user->getLastname() . ' ' . $user->getFirstname();
            }, $model, ['label' => 'Utilisateur']);
        }

        if ($user->getGroup() === null) {
            $inputs[] = Input::submit(($model === null ? 'Ajouter' : 'Modifier'), ['class' => 'button button-black']);
        } else {
            $inputs[] = Input::submit(($model === null ? 'Ajouter' : 'Modifier et valider'), [
                'class' => 'button button-black'
            ]);
        }

        return $inputs;
    }

    public static function getRules(): array
    {
        $rules = [
            'batch_id' => ['required'],
            'type' => ['required', 'in:1:2'],
            'description' => ['required', 'min:15', 'max:3000'],
            'price' => ['required', 'min:0']
        ];

        /** @var UsersModel $user */
        $user = Auth::getUser();

        if ($user->getGroup() !== null) {
            $rules['user_id'] = ['required'];
        }

        return $rules;
    }

    public static function getLabels(): array
    {
        $labels = [
            'batch_id' => 'lot',
            'type' => 'type',
            'description' => 'description',
            'price' => 'prix'
        ];

        /** @var UsersModel $user */
        $user = Auth::getUser();

        if ($user->getGroup() !== null) {
            $labels['user_id'] = 'utilisateur';
        }

        return $labels;
    }
}
