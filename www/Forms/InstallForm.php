<?php

namespace ESGI\Forms;

use ESGI\Core\Forms\FormInterface;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;

class InstallForm implements FormInterface
{
    public static function getConfiguration(?ModelInterface $model = null): array
    {
        return [
            'class' => 'form',
            'action' => '',
            'method' => 'post'
        ];
    }

    public static function getInputs(?ModelInterface $model = null): array
    {
        return [
            Input::select('env', $model, ['label' => 'Environnement'], [
                'production' => 'production (recommandé)',
                'development' => 'développement (pour les développeurs, debug activé)'
            ]),
            Input::text('db_host', $model, [
                'label' => 'Hôte de la base de données',
                'placeholder' => 'ex : 127.0.0.1',
                'value' => $_POST['db_host'] ?? ''
            ]),
            Input::text('db_name', $model, [
                'label' => 'Nom de la base de données',
                'placeholder' => 'ex : database',
                'value' => $_POST['db_name'] ?? ''
            ]),
            Input::text('db_user', $model, [
                'label' => 'Nom d\'utilisateur de la base de données',
                'placeholder' => 'ex : root',
                'value' => $_POST['db_user'] ?? ''
            ]),
            Input::password('db_password', $model, [
                'label' => 'Mot de passe de la base de données',
                'placeholder' => 'ex : root',
                'value' => $_POST['db_password'] ?? ''
            ]),
            Input::separator(),
            Input::text('mailer_host', $model, [
                'label' => 'Hôte du serveur mail',
                'placeholder' => 'ex : 127.0.0.1',
                'value' => $_POST['mailer_host'] ?? ''
            ]),
            Input::number('mailer_port', $model, [
                'label' => 'Port du serveur mail',
                'placeholder' => 'ex : 465',
                'value' => $_POST['mailer_port'] ?? ''
            ]),
            Input::text('mailer_username', $model, [
                'label' => 'Nom d\'utilisateur du serveur mail',
                'placeholder' => 'ex : webmail',
                'value' => $_POST['mailer_username'] ?? ''
            ]),
            Input::password('mailer_password', $model, [
                'label' => 'Mot de passe du serveur mail',
                'placeholder' => 'ex : password',
                'value' => $_POST['mailer_password'] ?? ''
            ]),
            Input::email('mailer_from', $model, [
                'label' => 'Adresse du serveur mail',
                'placeholder' => 'ex : no-reply@localhost',
                'value' => $_POST['mailer_from'] ?? ''
            ]),
            Input::separator(),
            Input::text('firstname', $model, [
                'label' => 'Prénom de l\'utilisateur',
                'placeholder' => 'ex : Arthur',
                'value' => $_POST['firstname'] ?? ''
            ]),
            Input::text('lastname', $model, [
                'label' => 'Nom de l\'utilisateur',
                'placeholder' => 'ex : Rimbaud',
                'value' => $_POST['lastname'] ?? ''
            ]),
            Input::email('email', $model, [
                'label' => 'Email de l\'utilisateur',
                'placeholder' => 'ex : contact@efysimmobilier.fr',
                'value' => $_POST['email'] ?? ''
            ]),
            Input::password('password', $model, [
                'label' => 'Mot de passe de l\'utilisateur',
                'value' => $_POST['password'] ?? ''
            ]),
            Input::submit('Installer', ['class' => 'button button-black'])
        ];
    }

    public static function getRules(): array
    {
        return [
            'env' => ['required', 'in:production:development'],
            'db_host' => ['required', 'min:4', 'max:255'],
            'db_name' => ['required', 'min:2', 'max:255'],
            'db_user' => ['required', 'min:2', 'max:255'],
            'db_password' => ['nullable', 'max:255'],
            'mailer_host' => ['required', 'min:2', 'max:255'],
            'mailer_port' => ['required', 'min:2', 'max:255'],
            'mailer_from' => ['required', 'email'],
            'mailer_username' => ['required', 'min:2', 'max:255'],
            'mailer_password' => ['required', 'min:2'],
            'firstname' => ['required', 'min:2', 'max:50'],
            'lastname' => ['required', 'min:2', 'max:100'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:4'],
        ];
    }

    public static function getLabels(): array
    {
        return [
            'env' => 'environnement',
            'db_host' => 'hôte de la base de données',
            'db_name' => 'nom de la base de données',
            'db_user' => 'nom d\'utilisateur de la base de données',
            'db_password' => 'mot de passe de la base de données',
            'mailer_host' => 'hôte du serveur mail',
            'mailer_port' => 'port du serveur mail',
            'mailer_from' => 'adresse du serveur mail',
            'mailer_username' => 'nom d\'utilisateur du serveur mail',
            'mailer_password' => 'mot de passe du serveur mail',
            'firstname' => 'prénom',
            'lastname' => 'nom',
            'email' => 'email',
            'password' => 'mot de passe'
        ];
    }
}
