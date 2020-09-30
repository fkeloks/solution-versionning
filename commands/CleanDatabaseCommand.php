<?php

namespace ESGI\Commands;

use ESGI\Core\Database\Database;

class CleanDatabaseCommand implements CommandInterface
{
    public static function process(array $arguments): void
    {
        $migrations = glob('migrations/*_create_*_table.sql');
        $sql = ['SET FOREIGN_KEY_CHECKS = 0;'];

        foreach ($migrations as $migration) {
            preg_match('/.*_create_(\w+)_table.sql$/m', $migration, $match);
            $sql[] = 'DROP TABLE IF EXISTS ' . $match[1] . ';';
        }

        $sql[] = 'SET FOREIGN_KEY_CHECKS = 1;';

        $pdo = Database::getPdo();
        $pdo->exec(implode(' ', $sql));

        echo 'Les tables de la base de données ont étés supprimées.' . PHP_EOL;
    }
}
