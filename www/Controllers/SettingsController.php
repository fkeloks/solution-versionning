<?php

namespace ESGI\Controllers;

use ESGI\Core\Validation\Validation;
use ESGI\Forms\SettingsForm;
use ESGI\Models\SettingsModel;

class SettingsController extends Controller
{
    public $security = [
        'indexAction' => 'settings.index',
        'editAction' => 'settings.edit'
    ];

    public function indexAction(): void
    {
        $settings = SettingsModel::fetchAll();

        $this->render('settings.index', 'backend', ['settings' => $settings]);
    }

    public function editAction(): void
    {
        if (empty($_GET['id'])) {
            redirect('administration');
        }

        $setting = SettingsModel::find($_GET['id']);

        if (!$setting) {
            redirect('administration');
            exit();
        }

        if (!empty($_POST)) {
            $validation = Validation::create(SettingsForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('settings.edit', 'backend', [
                    'setting' => $setting,
                    'errors' => $validation->getErrors()
                ]);

                return;
            }

            $setting->update();
            redirect('settings.index');
        }

        $this->render('settings.edit', 'backend', [
            'setting' => $setting,
            'errors' => []
        ]);
    }
}
