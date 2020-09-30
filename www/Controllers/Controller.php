<?php

namespace ESGI\Controllers;

use ESGI\Core\Security\NotAllowedException;
use ESGI\Core\Security\Security;
use ESGI\Core\Tools\App;
use ESGI\Core\Tools\DebugBar;

abstract class Controller
{
    public $security = [];

    /**
     * Call controller action (with security checks)
     *
     * @param string $action
     *
     * @throws NotAllowedException
     */
    public function callAction(string $action): void
    {
        if (array_key_exists($action, $this->security)) {
            Security::mustHavePermissionTo($this->security[$action]);
        }

        if (!App::isInTestMode()) {
            $this->$action();
        }
    }

    /**
     * Render a view (HTML format)
     *
     * @param string $view
     * @param string $layout
     * @param array $arguments
     */
    protected function render(string $view, string $layout = 'frontend', array $arguments = []): void
    {
        if (!App::isInTestMode()) {
            $view = str_replace('.', DIRECTORY_SEPARATOR, $view);
            DebugBar::addEntry('views', $view, true);

            extract($arguments, EXTR_OVERWRITE);
            include __DIR__ . '/../views/layouts/' . $layout . '.php';
        }
    }
}
