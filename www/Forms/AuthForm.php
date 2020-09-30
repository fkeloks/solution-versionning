<?php

namespace ESGI\Forms;

use ESGI\Core\Forms\FormInterface;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;
use ESGI\Helpers\Route;

class AuthForm implements FormInterface
{
    public static function getConfiguration(?ModelInterface $model = null): array
    {
        if (Route::getCurrentUrl() === '/connexion') {
            return [
                'class' => 'form',
                'action' => url('auth.login'),
                'method' => 'post'
            ];
        }

        return [
            'class' => 'form',
            'action' => url('auth.register'),
            'method' => 'post'
        ];
    }

    public static function getInputs(?ModelInterface $model = null): array
    {
        if (Route::getCurrentUrl() === '/connexion') {
            return [
                Input::email('email', $model, ['label' => 'Adresse email', 'placeholder' => 'Ex: jean-dupond@exemple.fr']),
                Input::password('password', $model, ['label' => 'Mot de passe']),
                Input::checkbox('reminded', ['label' => 'Se souvenir de moi']),
                Input::submit('Connexion', ['class' => 'button button-black'])
            ];
        }

        return [
            Input::text('lastname', $model, ['label' => 'Nom', 'placeholder' => 'Ex: Dupond']),
            Input::text('firstname', $model, ['label' => 'Prénom', 'placeholder' => 'Ex: Jean']),
            Input::email('email', $model, ['label' => 'Adresse email', 'placeholder' => 'Ex: jean-dupond@exemple.fr']),
            Input::password('password', $model, ['label' => 'Mot de passe', 'placeholder' => 'Ex : **********']),
            Input::password('password_confirm', $model, ['label' => 'Confirmation du mot de passe', 'placeholder' => 'Ex : **********']),
            Input::submit('Inscription', ['class' => 'button button-black'])
        ];
    }

    public static function getRules(): array
    {
        if (Route::getCurrentUrl() === '/connexion') {
            return [
                'email' => ['required', 'email', 'min:6', 'max:255'],
                'password' => ['required', 'min:4', 'max:255'],
                'reminded' => []
            ];
        }

        return [
            'firstname' => ['required', 'min:2', 'max:50'],
            'lastname' => ['required', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'min:6', 'max:255'],
            'password' => ['required', 'password', 'min:4', 'max:255'],
            'password_confirm' => ['required']
        ];
    }

    public static function getLabels(): array
    {
        if (Route::getCurrentUrl() === '/connexion') {
            return [
                'email' => 'adresse email',
                'password' => 'mot de passe'
            ];
        }

        return [
            'firstname' => 'prénom',
            'lastname' => 'nom',
            'email' => 'adresse email',
            'password' => 'mot de passe',
            'password_confirm' => 'confirmation du mot de passe'
        ];
    }
}
