<?php

namespace ESGI\Core\Models;

use ESGI\Core\Database\Query;
use ESGI\Core\Database\QueryBuilder;
use PDOStatement;

trait QueryableModel
{
    /**
     * Find model into database with an ID
     *
     * @param int $id
     * @param QueryBuilder|null $queryBuilder
     *
     * @return ModelInterface|null
     */
    public static function find(int $id, ?QueryBuilder $queryBuilder = null): ?ModelInterface
    {
        if (!$queryBuilder instanceof QueryBuilder) {
            $queryBuilder = new QueryBuilder;
        }

        $query = $queryBuilder->whereRaw(self::getTableName() . '.id = ' . $id);

        return self::fetch($query);
    }

    /**
     * Search and return a model from database
     *
     * @param string $search
     * @param string[] $columns
     * @param int $limit
     *
     * @return ModelInterface[]
     */
    public static function search(string $search, array $columns = [], int $limit = 10): array
    {
        $searchableColumns = implode(', ', empty($columns) ? static::$searchableColumns : $columns);
        $queryBuilder = (new QueryBuilder)
            ->selectRaw("*, match($searchableColumns) against('$search' in natural language mode) as score")
            ->whereRaw("match($searchableColumns) against('$search' in natural language mode)")
            ->order('score', 'desc')
            ->limit($limit);

        return self::fetchAll($queryBuilder);
    }

    /**
     * Find and return a model from database
     *
     * @param QueryBuilder|null $queryBuilder
     *
     * @return ModelInterface|null
     */
    public static function fetch(?QueryBuilder $queryBuilder = null): ?ModelInterface
    {
        $statement = self::getStatement($queryBuilder);

        if (!$statement) {
            return null;
        }

        $result = $statement->fetch();

        if (!is_array($result) || !count($result)) {
            return null;
        }

        return self::hydrate(static::class, $result);
    }

    /**
     * Find and return a collection of models from database
     *
     * @param QueryBuilder|null $queryBuilder
     *
     * @return ModelInterface[]
     */
    public static function fetchAll(?QueryBuilder $queryBuilder = null): array
    {
        $statement = self::getStatement($queryBuilder);

        if (!$statement) {
            return [];
        }

        $results = $statement->fetchAll();

        if (!is_array($results) || !count($results)) {
            return [];
        }

        return self::hydrateRows(static::class, $results);
    }

    /**
     * Returns count of fetched rows
     *
     * @param QueryBuilder|null $queryBuilder
     *
     * @return int
     */
    public static function count(?QueryBuilder $queryBuilder = null): int
    {
        $statement = self::getStatement($queryBuilder);

        if (!$statement) {
            return 0;
        }

        return $statement->rowCount();
    }

    /**
     * Execute and returns PDO statement
     *
     * @param QueryBuilder|null $queryBuilder
     *
     * @return PDOStatement|null
     */
    private static function getStatement(?QueryBuilder $queryBuilder = null): ?PDOStatement
    {
        if (!$queryBuilder) {
            $queryBuilder = (new QueryBuilder)->from(self::getTableName());
        } elseif (!$queryBuilder->from) {
            $queryBuilder->from(self::getTableName());
        }

        return Query::getStatement($queryBuilder);
    }
}
