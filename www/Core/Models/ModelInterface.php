<?php

namespace ESGI\Core\Models;

use ESGI\Core\Database\QueryBuilder;

interface ModelInterface
{
    /**
     * Returns current model ID
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Find model into database with an ID
     *
     * @param int $id
     * @param QueryBuilder|null $queryBuilder
     *
     * @return ModelInterface|null
     */
    public static function find(int $id, ?QueryBuilder $queryBuilder = null): ?ModelInterface;

    /**
     * Search and return a model from database
     *
     * @param string $search
     * @param string[] $columns
     * @param int $limit
     *
     * @return ModelInterface[]
     */
    public static function search(string $search, array $columns = [], int $limit = 10): array;

    /**
     * Find and return a model from database
     *
     * @param QueryBuilder|null $queryBuilder
     *
     * @return ModelInterface|null
     */
    public static function fetch(?QueryBuilder $queryBuilder = null): ?ModelInterface;

    /**
     * Find and return a collection of models from database
     *
     * @param QueryBuilder|null $queryBuilder
     *
     * @return ModelInterface[]
     */
    public static function fetchAll(?QueryBuilder $queryBuilder = null): array;

    /**
     * Returns count of fetched rows
     *
     * @param QueryBuilder|null $queryBuilder
     *
     * @return int
     */
    public static function count(?QueryBuilder $queryBuilder = null): int;

    /**
     * Insert current model to database
     */
    public function insert(): void;

    /**
     * Update current model to database
     */
    public function update(): void;

    /**
     * Delete current model from database
     *
     * @param int|string|int[] $id
     *
     * @return bool true on success or false on failure.
     */
    public static function delete($id): bool;

    /**
     * Return name of table
     *
     * @return string
     */
    public static function getTableName(): string;
}
