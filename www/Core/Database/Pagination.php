<?php

namespace ESGI\Core\Database;

class Pagination
{
    /** @var int */
    private static $DEFAULT_LIMIT = 10;

    /** @var array */
    private static $STORAGE = [];

    /**
     * Returns true if a page has passed to route parameters, false otherwise
     *
     * @return bool
     */
    public static function hasPage(): bool
    {
        return !empty($_GET['page']) && is_numeric($_GET['page']) && (int)$_GET['page'] <= 999;
    }

    /**
     * Returns current page number
     *
     * @return int
     */
    public static function getPage(): int
    {
        if (self::hasPage()) {
            return $_GET['page'];
        }

        return 1;
    }

    /**
     * Inject pagination to QueryBuilder
     *
     * @param string $table
     * @param int|null $limit
     * @param QueryBuilder|null $queryBuilder
     *
     * @return QueryBuilder
     */
    public static function getQuery(string $table, ?int $limit = null, ?QueryBuilder $queryBuilder = null): QueryBuilder
    {
        if (!is_numeric($limit)) {
            $limit = self::$DEFAULT_LIMIT;
        }

        self::$STORAGE[$table] = ['limit' => $limit];

        if (!$queryBuilder instanceof QueryBuilder) {
            $queryBuilder = new QueryBuilder;
        }

        self::storePageCount($table, $queryBuilder);

        return $queryBuilder
            ->limit($limit)
            ->offset((self::getPage() - 1) * $limit);
    }

    /**
     * Returns stored page count
     *
     * @param string $table
     *
     * @return int
     */
    public static function getPageCount(string $table): int
    {
        if (!isset(self::$STORAGE[$table])) {
            return 1;
        }

        return (int)ceil(self::$STORAGE[$table]['count'] / self::$STORAGE[$table]['limit']);
    }

    /**
     * Store page count to self-static storage
     *
     * @param string $table
     * @param QueryBuilder $queryBuilder
     */
    private static function storePageCount(string $table, QueryBuilder $queryBuilder): void
    {
        $queryBuilder = clone $queryBuilder;
        $queryBuilder->selectRaw('count(*)')->from($table);

        $statement = Query::getStatement($queryBuilder);

        self::$STORAGE[$table]['count'] = $statement instanceof \PDOStatement ? (int)$statement->fetchColumn() : 0;
    }
}
