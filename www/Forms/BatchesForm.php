<?php

namespace ESGI\Forms;

use ESGI\Core\Auth\Auth;
use ESGI\Core\Database\QueryBuilder;
use ESGI\Core\Forms\FormInterface;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;
use ESGI\Models\PropertiesModel;
use ESGI\Models\UsersModel;

class BatchesForm implements FormInterface
{
    public static function getConfiguration(?ModelInterface $model = null): array
    {
        return [
            'class' => 'form',
            'action' => url('batches.' . ($model === null ? 'add' : 'edit')),
            'method' => 'post'
        ];
    }

    public static function getInputs(?ModelInterface $model = null): array
    {
        $queryBuilder = (new QueryBuilder)->order('address', 'asc');

        /** @var UsersModel $user */
        $user = Auth::getUser();
        if ($user->getGroup() === null) {
            $queryBuilder->where('user_id', '=', $user->getId());
        }

        $properties = PropertiesModel::fetchAll($queryBuilder);

        return [
            Input::number('number', $model, ['label' => 'Numéro', 'placeholder' => 'Ex: 12']),
            Input::select('type', $model, ['label' => 'Type'], PropertiesModel::TYPES),
            Input::number('surface', $model, ['label' => 'Superficie', 'placeholder' => 'Ex: 56', 'step' => '0.1']),
            Input::relation('property_id', $properties, static function (PropertiesModel $property) {
                return PropertiesModel::TYPES[$property->getType()] . ' - ' . $property->getAddress();
            }, $model, ['label' => 'Propriété']),
            Input::submit(($model === null ? 'Ajouter' : 'Modifier'), ['class' => 'button button-black'])
        ];
    }

    public static function getRules(): array
    {
        return [
            'number' => ['required', 'min:1'],
            'type' => ['required', 'in:1:2'],
            'surface' => ['required', 'min:8'],
            'property_id' => ['required']
        ];
    }

    public static function getLabels(): array
    {
        return [
            'number' => 'numéro',
            'type' => 'type',
            'surface' => 'surface',
            'property_id' => 'propriété'
        ];
    }
}
