<?php

namespace ESGI\Core\Database;

use ESGI\Core\Tools\App;
use ESGI\Core\Tools\DebugBar;
use PDOStatement;

class Query
{
    /**
     * Execute and returns PDO statement
     *
     * @param QueryBuilder $queryBuilder
     *
     * @return PDOStatement|null
     */
    public static function getStatement(QueryBuilder $queryBuilder): ?PDOStatement
    {
        $query = $queryBuilder->getQuery();

        $statement = self::mesureExecutionTime($query, static function () use ($query) {
            return Database::getPdo()->query($query);
        });

        return $statement instanceof PDOStatement ? $statement : null;
    }

    /**
     * Add query execution time to DebugBar helper
     *
     * @param string $query
     * @param callable $callback
     *
     * @return PDOStatement|null
     */
    public static function mesureExecutionTime(string $query, callable $callback): ?PDOStatement
    {
        if (!App::isInDevelopmentMode()) {
            return $callback();
        }

        $startTime = microtime(true);
        $callback = $callback();
        $executionTime = round((microtime(true) - $startTime) * 1000, 3) . 'ms';
        DebugBar::addEntry('queries', $query . " <small>(${executionTime})</small>", true);

        return $callback;
    }
}
