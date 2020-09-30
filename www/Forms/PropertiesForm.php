<?php

namespace ESGI\Forms;

use ESGI\Core\Auth\Auth;
use ESGI\Core\Forms\FormInterface;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;
use ESGI\Models\OwnersModel;

class PropertiesForm implements FormInterface
{
    /** @var string[] */
    public const TYPES = [
        1 => 'Maison',
        2 => 'Appartement',
    ];

    public static function getConfiguration(?ModelInterface $model = null): array
    {
        return [
            'class' => 'form',
            'action' => url('properties.' . ($model === null ? 'add' : 'edit')),
            'method' => 'post'
        ];
    }

    public static function getInputs(?ModelInterface $model = null): array
    {
        $inputs = [
            Input::select('type', $model, ['label' => 'Type'], self::TYPES),
            Input::text('address', $model, ['label' => 'Adresse', 'placeholder' => 'Ex: 6 rue de Paris, 7500 Paris']),
            Input::date('construction_date', $model, ['label' => 'Date de construction']),
        ];

        if (Auth::getUser()->getGroupId() !== null) {
            $inputs[] = Input::relation('owner_id', OwnersModel::class, static function (OwnersModel $owners) {
                return $owners->getLastName() . ' ' . $owners->getFirstName();
            }, $model, ['label' => 'Propriétaire']);
        }

        $inputs[] = Input::submit(($model === null ? 'Ajouter' : 'Modifier'), ['class' => 'button button-black']);

        return $inputs;
    }

    public static function getRules(): array
    {
        $rules = [
            'type' => ['required', 'in:1:2'],
            'address' => ['required', 'min:6'],
            'construction_date' => ['required', 'date:' . '1000-01-01:3000-01-01']
        ];

        if (Auth::getUser()->getGroupId() !== null) {
            $rules['owner_id'] = ['required'];
        }

        return $rules;
    }

    public static function getLabels(): array
    {
        return [
            'type' => 'type',
            'address' => 'adresse',
            'construction_date' => 'date de construction',
            'owner_id' => 'propriétaire'
        ];
    }
}
