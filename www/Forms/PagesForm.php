<?php

namespace ESGI\Forms;

use ESGI\Core\Forms\FormInterface;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;
use ESGI\Models\PagesModel;

class PagesForm implements FormInterface
{
    public static function getConfiguration(?ModelInterface $model = null): array
    {
        return [
            'class' => 'form',
            'action' => url('pages.' . ($model === null ? 'add' : 'edit')),
            'method' => 'post'
        ];
    }

    public static function getInputs(?ModelInterface $model = null): array
    {
        return [
            Input::text('title', $model, ['label' => 'Titre', 'placeholder' => 'Ex: Mon super titre']),
            Input::text('path', $model, ['label' => 'Chemin', 'placeholder' => 'Ex: /accueil']),
            Input::select('status', $model, ['label' => 'Statut'], [
                PagesModel::STATUS_HIDDEN => 'Caché',
                PagesModel::STATUS_PUBLISHED => 'Publié',
                PagesModel::STATUS_DRAFT => 'Brouillon'
            ]),
            Input::textarea('description', $model, ['label' => 'Description', 'required' => false]),
            Input::submit(($model === null ? 'Ajouter' : 'Modifier'), ['class' => 'button button-black'])
        ];
    }

    public static function getRules(): array
    {
        return [
            'title' => ['required', 'min:2', 'max:255'],
            'path' => ['required', 'max:255'],
            'status' => ['required', 'in:0:1:2'],
            'description' => ['required', 'min:5', 'max:200']
        ];
    }

    public static function getLabels(): array
    {
        return [
            'title' => 'titre',
            'path' => 'chemin',
            'status' => 'statut',
            'description' => 'description'
        ];
    }
}
