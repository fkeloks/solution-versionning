<?php

namespace ESGI\Forms;

use ESGI\Core\Forms\FormInterface;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;
use ESGI\Models\SettingsModel;

class SettingsForm implements FormInterface
{
    public static function getConfiguration(?ModelInterface $model = null): array
    {
        return [
            'class' => 'form',
            'action' => url('settings.edit'),
            'method' => 'post'
        ];
    }

    public static function getInputs(?ModelInterface $model = null): array
    {
        if ($model->getOptions() != null) {
            $inputs = [
                Input::select('value', $model, ['label' => $model ? $model->getLabel() : 'Valeur'], $model->getOptions()),
                Input::submit(($model === null ? 'Ajouter' : 'Modifier'), ['class' => 'button button-black'])
            ];
        } else {
            $inputs = [
                Input::textarea('value', $model, ['label' => $model ? $model->getLabel() : 'Valeur']),
                Input::submit(($model === null ? 'Ajouter' : 'Modifier'), ['class' => 'button button-black'])
            ];
        }

        return $inputs;
    }

    public static function getRules(): array
    {
        return ['value' => ['required', 'min:1', 'max:300']];
    }

    public static function getLabels(?ModelInterface $model = null): array
    {
        return ['value' => 'valeur'];
    }
}
