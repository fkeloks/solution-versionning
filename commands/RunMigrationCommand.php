<?php

namespace ESGI\Commands;

use ESGI\Core\Database\Database;

class RunMigrationCommand implements CommandInterface
{
    public static function process(array $arguments): void
    {
        echo 'Recherche des migrations...' . PHP_EOL;

        $migrations = glob(dirname(__DIR__) . '/migrations/*.sql');
        $pdo = Database::getPdo();
        $pdo->exec(file_get_contents(dirname(__DIR__) . '/migrations/2020_01_01_000001_create_migrations_table.sql'));

        $executedMigrations = $pdo->query('SELECT * FROM migrations')->fetchAll();
        foreach ($migrations as $migration) {
            $find = false;
            foreach ($executedMigrations as $executedMigration) {
                if (array_key_exists('migrations.filename', $executedMigration)) {
                    $migrationFileName = strstr($migration, '/migrations');
                    if (strstr($executedMigration['migrations.filename'], '/migrations') === $migrationFileName) {
                        $find = true;
                    }
                }
            }

            if (!$find) {
                echo '  - execution du fichier ' . basename($migration) . '...' . PHP_EOL;
                $pdo->exec(file_get_contents($migration));
                $pdo->exec('INSERT INTO `migrations` (`filename`) VALUES ("' . $migration . '")');
            }
        }

        echo PHP_EOL . 'Les migrations sont à jour.' . PHP_EOL;
    }
}
