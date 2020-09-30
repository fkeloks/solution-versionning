<?php

namespace ESGI\Controllers;

use ESGI\Commands\RunMigrationCommand;
use ESGI\Core\Auth\Auth;
use ESGI\Core\Configuration\Config;
use ESGI\Core\Database\Database;
use ESGI\Core\Database\DatabaseException;
use ESGI\Core\Database\QueryBuilder;
use ESGI\Core\Tools\Mail;
use ESGI\Core\Validation\Validation;
use ESGI\Forms\InstallForm;
use ESGI\Models\GroupsModel;
use ESGI\Models\UsersModel;

class InstallController extends Controller
{
    public function installAction(): void
    {
        if (!empty($_POST)) {
            $validation = Validation::create(InstallForm::class)->validate();

            if ($validation->hasErrors()) {
                $this->render('install.install', 'basic', ['errors' => $validation->getErrors()]);

                return;
            }

            Config::set('APP_ENV', $_POST['env']);
            Config::set('DB_HOST', $_POST['db_host']);
            Config::set('DB_DATABASE', $_POST['db_name']);
            Config::set('DB_USERNAME', $_POST['db_user']);
            Config::set('DB_PASSWORD', $_POST['db_password']);

            try {
                $pdo = Database::getPdo();

                // Configuration
                $this->replaceConfigurationFile([
                    'APP_ENV' => $_POST['env'],
                    'DB_HOST' => $_POST['db_host'],
                    'DB_DATABASE' => $_POST['db_name'],
                    'DB_USERNAME' => $_POST['db_user'],
                    'DB_PASSWORD' => $_POST['db_password'],
                    'MAILER_HOST' => $_POST['mailer_host'],
                    'MAILER_PORT' => $_POST['mailer_port'],
                    'MAILER_FROM' => $_POST['mailer_from'],
                    'MAILER_USERNAME' => $_POST['mailer_username'],
                    'MAILER_PASSWORD' => $_POST['mailer_password'],
                ]);

                // Database migrations
                $commandsPath = dirname(BASE_PATH) . DIRECTORY_SEPARATOR . 'commands' . DIRECTORY_SEPARATOR;
                require $commandsPath . 'CommandInterface.php';
                require $commandsPath . 'RunMigrationCommand.php';
                ob_start();
                RunMigrationCommand::process([]);
                ob_clean();

                // Mail
                try {
                    $message = 'EfysImmobilier - L\'application est correctement installée, felicitations !';
                    Mail::create($message, $message)->send($_POST['email']);
                } catch (\Exception $exception) {
                    // No action
                }

                // Reset of database tables
                $tables = ['announcements', 'batches', 'events', 'owners', 'properties', 'reports', 'staff', 'users'];
                $pdo->exec('SET FOREIGN_KEY_CHECKS=0;');
                foreach ($tables as $table) {
                    $pdo->exec('DELETE FROM ' . $table);
                }
                $pdo->exec('SET FOREIGN_KEY_CHECKS=1;');

                // Insert new user
                (new UsersModel)
                    ->setLastname($_POST['lastname'])
                    ->setFirstname($_POST['firstname'])
                    ->setEmail($_POST['email'])
                    ->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT))
                    ->setGroupId(1)
                    ->setEmailConfirmed(true)
                    ->insert();

                // Connect user
                $queryBuilder = (new QueryBuilder)
                    ->join(GroupsModel::getTableName(), 'group_id')
                    ->where('email', '=', $_POST['email']);

                /** @var UsersModel $user */
                $user = UsersModel::fetch($queryBuilder);
                Auth::login($user);

                // Remove installation script
                $installerFilePath = BASE_PATH . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'install.php';
                unlink($installerFilePath);

                redirect('settings.index');
            } catch (DatabaseException $exception) {
                $this->render('install.install', 'basic', [
                    'errors' => ['Echec de la connexion à la base de données. Veuillez vérifier les informations saisies']
                ]);

                return;
            }
        }

        $this->render('install.install', 'basic', ['errors' => []]);
    }

    /**
     * Replace configuration file by new parameters
     *
     * @param array $replacements
     */
    private function replaceConfigurationFile(array $replacements): void
    {
        $configuration = array_filter(Config::all(), static function ($value) {
            return !is_array($value);
        });

        foreach ($replacements as $key => $replacement) {
            $configuration[$key] = $replacement;
        }

        $newConfiguration = [];
        foreach ($configuration as $key => $value) {
            $newConfiguration[] = $key . '=' . $value;
        }

        file_put_contents(BASE_PATH . DIRECTORY_SEPARATOR . '.env', implode(PHP_EOL, $newConfiguration));
    }
}
