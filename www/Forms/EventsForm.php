<?php

namespace ESGI\Forms;

use ESGI\Core\Forms\FormInterface;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;
use ESGI\Models\StaffModel;

class EventsForm implements FormInterface
{
    public static function getConfiguration(?ModelInterface $model = null): array
    {
        return [
            'class' => 'form',
            'action' => url('planning.' . ($model === null ? 'add' : 'edit')),
            'method' => 'post'
        ];
    }

    public static function getInputs(?ModelInterface $model = null): array
    {
        return [
            Input::text('name', $model, ['label' => 'nom de l\'évènement', 'placeholder' => 'Ex: Conférence']),
            Input::date('date_start', $model, ['label' => 'Date de début', 'placeholder' => 'Ex: 2020-05-13']),
            Input::date('date_end', $model, ['label' => 'Date de fin', 'placeholder' => 'Ex: 2020-05-13']),
            Input::time('time_start', $model, ['label' => 'Heure de début', 'placeholder' => 'Ex: 10:00']),
            Input::time('time_end', $model, ['label' => 'Heure de fin', 'placeholder' => 'Ex: 10:00']),
            Input::select('type', $model, ['label' => 'Type'], [
                0 => 'Travail',
                1 => 'Évènement',
            ]),
            Input::relation('user_id', StaffModel::class, static function (StaffModel $staff) {
                return $staff->getLastname() . ' ' . $staff->getFirstname();
            }, $model, ['label' => 'Utilisateur']),
            Input::submit(($model === null ? 'Ajouter' : 'Modifier'), ['class' => 'button button-black'])
        ];
    }

    public static function getRules(): array
    {
        return [
            'name' => ['required', 'min:1', 'max:255'],
            'date_start' => [
                'required',
                'date:' . $_POST['date_start'] . ':' . $_POST['date_end'],
                'time:' . $_POST['time_start'] . ':' . $_POST['time_end']
            ],
            'date_end' => ['required'],
            'time_start' => ['required'],
            'time_end' => ['required'],
            'type' => ['required', 'in:0:1'],
            'user_id' => ['required']
        ];
    }

    public static function getLabels(): array
    {
        return [
            'name' => 'nom de l\'évènement',
            'date_start' => 'date de début',
            'date_end' => 'date de fin',
            'time_start' => 'heure de début',
            'time_end' => 'heure de fin',
            'type' => 'type',
            'user_id' => 'utilisateur'
        ];
    }
}
