<?php

namespace ESGI\Forms;

use ESGI\Core\Forms\FormInterface;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;

class StaffForm implements FormInterface
{
    public static function getConfiguration(?ModelInterface $model = null): array
    {
        return [
            'class' => 'form',
            'action' => url('staff.' . ($model === null ? 'add' : 'edit')),
            'method' => 'post'
        ];
    }

    public static function getInputs(?ModelInterface $model = null): array
    {
        return [
            Input::text('firstname', $model, ['label' => 'Prénom', 'placeholder' => 'Ex : John']),
            Input::text('lastname', $model, ['label' => 'Nom', 'placeholder' => 'Ex : Doe']),
            Input::text('function', $model, ['label' => 'Fonction', 'placeholder' => 'Ex : Gestionnaire']),
            Input::number('salary', $model, ['label' => 'Salaire', 'placeholder' => 'Ex : 1 200€']),
            Input::select('status', $model, ['label' => 'Statut'], [
                0 => 'Actif',
                1 => 'Inactif',
            ]),
            Input::submit(($model === null ? 'Ajouter' : 'Modifier'), ['class' => 'button button-black'])
        ];
    }

    public static function getRules(): array
    {
        return [
            'firstname' => ['required', 'min:2', 'max:50'],
            'lastname' => ['required', 'min:2', 'max:100'],
            'function' => ['required', 'min:2', 'max:255'],
            'salary' => ['required', 'min:10'],
            'status' => ['required']
        ];
    }

    public static function getLabels(): array
    {
        return [
            'firstname' => 'prénom',
            'lastname' => 'nom',
            'function' => 'fonction',
            'salary' => 'salaire',
            'status' => 'statut'
        ];
    }
}
