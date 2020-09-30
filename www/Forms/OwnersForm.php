<?php

namespace ESGI\Forms;

use ESGI\Core\Forms\FormInterface;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;

class OwnersForm implements FormInterface
{
    public static function getConfiguration(?ModelInterface $model = null): array
    {
        return [
            'class' => 'form',
            'action' => url('owners.' . ($model === null ? 'add' : 'edit')),
            'method' => 'post'
        ];
    }

    public static function getInputs(?ModelInterface $model = null): array
    {
        return [
            Input::text('firstname', $model, ['label' => 'Prénom', 'placeholder' => 'Ex : Marie']),
            Input::text('lastname', $model, ['label' => 'Nom', 'placeholder' => 'Ex : Moulin']),
            Input::email('mail', $model, ['label' => 'E-mail', 'placeholder' => 'Ex : mariemoulin@gmail.com']),
            Input::text('address', $model, [
                'label' => 'Adresse',
                'placeholder' => 'Ex : 78 rue du bout de la bouteille'
            ]),
            Input::tel('phone', $model, [
                'label' => 'Téléphone',
                'placeholder' => 'Ex : 07 77 01 01 12',
                'pattern' => '(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}'
            ]),
            Input::submit(($model === null ? 'Ajouter' : 'Modifier'), ['class' => 'button button-black'])
        ];
    }

    public static function getRules(): array
    {
        return [
            'firstname' => ['required', 'min:2', 'max:50'],
            'lastname' => ['required', 'min:2', 'max:100'],
            'mail' => ['required', 'email'],
            'address' => ['required'],
            'phone' => ['required']
        ];
    }

    public static function getLabels(): array
    {
        return [
            'firstname' => 'prénom',
            'lastname' => 'nom',
            'mail' => 'email',
            'address' => 'adresse',
            'phone' => 'téléphone'
        ];
    }
}
