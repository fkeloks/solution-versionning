<?php

namespace ESGI\Core\Database;

use ESGI\Core\Configuration\Config;
use PDO;

// Fake commit to resolve bug on production
abstract class Database
{
    /** @var PDO $pdo */
    private static $pdo;

    /**
     * Database instantiation (with PDF helper)
     *
     * @return PDO
     *
     * @throws DatabaseException
     */
    public static function getPdo(): PDO
    {
        if (self::$pdo === null) {
            try {
                $driver = Config::get('DB_DRIVER');
                $host = Config::get('DB_HOST');
                $database = Config::get('DB_DATABASE');

                self::$pdo = new PDO(
                    $driver . ':host=' . $host . ';' . 'dbname=' . $database . ';charset=utf8',
                    Config::get('DB_USERNAME'),
                    Config::get('DB_PASSWORD')
                );

                // PDF options
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true);
            } catch (\Exception $exception) {
                throw new DatabaseException(
                    'Une erreur est survenue lors de la connexion à la base de données.',
                    $exception->getCode()
                );
            }
        }

        return self::$pdo;
    }
}
