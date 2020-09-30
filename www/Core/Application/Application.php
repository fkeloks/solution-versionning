<?php

namespace ESGI\Core\Application;

use ESGI\Controllers\AuthController;
use ESGI\Controllers\DefaultController;
use ESGI\Core\Auth\Auth;
use ESGI\Core\Configuration\Config;
use ESGI\Core\Configuration\ConfigLoader;
use ESGI\Core\Security\NotAllowedException;
use ESGI\Core\Tools\DebugBar;
use ESGI\Models\SettingsModel;
use ESGI\Models\UsersModel;

class Application
{
    /**
     * Initialisation de l'application
     */
    public static function boot(): void
    {
        date_default_timezone_set('Europe/Paris');

        self::installerProtection();
        self::registerConfiguration();
        self::startSession();

        if (!defined('EXECUTE_AS_PHPUNIT') && !defined('EXECUTE_AS_INSTALLER')) {
            self::proceedToRouting();
        }
    }

    /**
     * Do not start the application if it is not installed
     */
    public static function installerProtection(): void
    {
        $installerFilePath = BASE_PATH . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'install.php';

        if (!defined('EXECUTE_AS_INSTALLER') && file_exists($installerFilePath)) {
            (new DefaultController)->errorAction(503, 'Application non-installée.');
        }
    }

    /**
     * Configuration de l'application
     * - depuis les fichiers de configuration
     * - depuis la table "settings" de la base de données
     */
    private static function registerConfiguration(): void
    {
        (new ConfigLoader(BASE_PATH))->parseFiles();

        if (!defined('EXECUTE_AS_INSTALLER')) {
            /** @var SettingsModel[] $settings */
            $settings = SettingsModel::fetchAll();
            foreach ($settings as $setting) {
                Config::set($setting->getKey(), $setting->getValue());
            }
        }
    }

    /**
     * Mise en place de la session (utilisée pour l'authentification)
     */
    private static function startSession(): void
    {
        session_start();
    }

    /**
     * Routing : recherche & execution du controller attribué à l'uri courante
     */
    private static function proceedToRouting(): void
    {
        // Obtain current URI & list all configured routes
        $uri = preg_replace('/\?.*$/', '', $_SERVER['REDIRECT_URL'] ?? $_SERVER['REQUEST_URI']);
        $routes = yaml_parse_file(BASE_PATH . DIRECTORY_SEPARATOR . 'routes.yml');

        if (array_key_exists($uri, $routes)) {
            DebugBar::addEntry('route', $routes[$uri]['name'] ?? '?');

            $controller = $routes[$uri]['controller'] . 'Controller';
            $action = $routes[$uri]['action'] . 'Action';
            $controllerPath = BASE_PATH . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $controller . '.php';

            if (file_exists($controllerPath)) {
                include $controllerPath;
                $controller = 'ESGI\\Controllers\\' . $controller;
                if (class_exists($controller) && method_exists($controller, $action)) {
                    $auth = array_key_exists('auth', $routes[$uri]) && (bool)$routes[$uri]['auth'] === true;
                    self::runController($controller, $action, $auth);

                    exit();
                }
            }
        }

        // Default action : simples pages (eg: /contact)
        (new DefaultController)->pageAction();
    }

    /**
     * Execute une méthode d'un controller
     *
     * @param string $controller
     * @param string $action
     * @param bool $auth
     */
    private static function runController(string $controller, string $action, bool $auth): void
    {
        $isLogged = Auth::isLogged();

        // Add authentification to DebugBar helper
        DebugBar::addEntry('authentification', 'Auth: <i>' . ($auth ? 'yes' : 'no') . '</i>', true);
        DebugBar::addEntry('authentification', 'Logged: <i>' . ($isLogged ? 'yes' : 'no') . '</i>', true);

        if ($auth) {
            if (!$isLogged) {
                (new AuthController)->rememberMe();
                (new DefaultController)->errorAction(403, 'Accès refusé');
            } else {
                /** @var UsersModel $user */
                $user = Auth::getUser();

                // Check if user has an confirmed account
                if ($user->getEmailConfirmed() !== 1) {
                    (new DefaultController)->errorAction(
                        401,
                        'Vous devez d\'abord cliquer sur le lien de confirmation envoyé sur votre boite mail pour voir cette page.'
                    );
                }
            }
        }

        // Turn on output buffering
        ob_start();

        try {
            $controller = new $controller;

            /** @var callable $callback */
            $callback = [$controller, 'callAction'];
            $callback($action);
        } catch (NotAllowedException $notAllowedException) {
            (new DefaultController)->errorAction(403, 'Accès refusé');
        }

        // Inject output buffering to $response variable
        $response = ob_get_clean();

        // Add execution time to DebugBar helper
        if (defined(START_TIME)) {
            $executionTime = round((microtime(true) - START_TIME) * 1000, 3) . 'ms';
            DebugBar::addEntry('executionTime', $executionTime);
        }

        echo $response;
    }
}
