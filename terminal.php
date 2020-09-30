<?php

use ESGI\Core\Autoloader\Autoloader;
use ESGI\Core\Configuration\ConfigLoader;

require 'www/Core/Autoload/Autoloader.php';
require 'www/helpers.php';

$command = $argv[1] ?? null;

if (!$command) {
    echo 'Liste des commandes disponibles :' . PHP_EOL;
    echo '  - database:clean  : Supprime les tables de la base de données' . PHP_EOL;
    echo '  - migrations:make : Permet de créer automatiquement une migration datée' . PHP_EOL;
    echo '  - migrations:run  : Lance les migrations qui n\'ont pas encore été exécutées' . PHP_EOL;
    exit();
}

// Autoloader
Autoloader::setBasePath(__DIR__ . DIRECTORY_SEPARATOR . 'www');
Autoloader::setFirstNamespace('ESGI');

spl_autoload_register([Autoloader::class, 'loader']);

// Configuration
(new ConfigLoader(__DIR__ . DIRECTORY_SEPARATOR . 'www'))->parseFiles();

require 'commands/CommandInterface.php';

switch ($command) {
    case 'database:clean':
        require 'commands/CleanDatabaseCommand.php';
        \ESGI\Commands\CleanDatabaseCommand::process($argv);
        break;
    case 'migrations:make':
        require 'commands/MakeMigrationCommand.php';
        \ESGI\Commands\MakeMigrationCommand::process($argv);
        break;
    case 'migrations:run':
        require 'commands/RunMigrationCommand.php';
        \ESGI\Commands\RunMigrationCommand::process($argv);
        break;
    default:
        echo 'Commande inconnue' . PHP_EOL;
}
