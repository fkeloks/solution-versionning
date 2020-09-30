<?php

namespace ESGI\Forms;

use ESGI\Core\Forms\FormInterface;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;

class ReportsForm implements FormInterface
{
    public static function getConfiguration(?ModelInterface $model = null): array
    {
        return [
            'class' => 'form',
            'action' => url('announcements.' . 'report'),
            'method' => 'post'
        ];
    }

    public static function getInputs(?ModelInterface $model = null): array
    {
        return [
            Input::textarea('reason', $model, ['label' => 'Motif du signalement']),
            Input::submit('Signaler', ['class' => 'button button-black'])
        ];
    }

    public static function getRules(): array
    {
        return ['reason' => ['required', 'min:5', 'max:255']];
    }

    public static function getLabels(): array
    {
        return ['reason' => 'Motif de signalement'];
    }
}
