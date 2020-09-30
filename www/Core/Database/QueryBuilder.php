<?php

namespace ESGI\Core\Database;

class QueryBuilder
{
    /** @var string */
    private $select = '*';

    /** @var string|null */
    public $from;

    /** @var array */
    private $joins;

    /** @var array */
    private $wheres;

    /** @var array */
    private $order;

    /** @var int|null */
    private $limit;

    /** @var int|null */
    private $offset;

    /**
     * SQL select
     * Select *, select (id, name), select ...
     *
     * @param string|string[] $columns
     *
     * @return $this
     */
    public function select($columns = '*'): self
    {
        if (is_string($columns)) {
            $this->select = $columns;
        } elseif (is_array($columns)) {
            $this->select = '(' . implode(', ', $columns) . ')';
        }

        return $this;
    }

    /**
     * SQL select (raw method)
     *
     * @param string $raw
     *
     * @return $this
     */
    public function selectRaw(string $raw): self
    {
        $this->select = $raw;

        return $this;
    }

    /**
     * SQL from
     *
     * @param string $table
     *
     * @return $this
     */
    public function from(string $table): self
    {
        $this->from = $table;

        return $this;
    }

    /**
     * SQL join
     *
     * @param string $related
     * @param string $localKey
     * @param string $foreignKey
     * @param string $operator
     * @param string $type
     * @param string|null $from
     *
     * @return $this
     */
    public function join(
        string $related,
        string $localKey,
        string $foreignKey = 'id',
        string $operator = '=',
        string $type = 'left',
        string $from = null
    ): self {
        $this->joins[] = [$related, $localKey, $foreignKey, $operator, strtoupper($type), $from];

        return $this;
    }

    /**
     * SQL where
     *
     * @param string $column
     * @param string $operator
     * @param string|int|bool $value
     * @param string $conditional
     *
     * @return $this
     */
    public function where(string $column, string $operator, $value, string $conditional = 'and'): self
    {
        if ($value === null) {
            $value = 'NULL';
        } else {
            $value = strpos((string)$value, ':') !== false ? $value : '\'' . $value . '\'';
        }

        $this->wheres[] = ['`' . $column . '`', $operator, $value, strtoupper($conditional)];

        return $this;
    }

    /**
     * SQL where (raw method)
     *
     * @param string $raw
     *
     * @return $this
     */
    public function whereRaw(string $raw): self
    {
        $this->wheres[] = [$raw];

        return $this;
    }

    /**
     * SQL order by
     *
     * @param string $column
     * @param string $direction
     *
     * @return $this
     */
    public function order(string $column, string $direction = 'asc'): self
    {
        $this->order = ['`' . $column . '`', strtoupper($direction)];

        return $this;
    }

    /**
     * SQL order by  (raw method)
     *
     * @param string $raw
     *
     * @return $this
     */
    public function orderRaw(string $raw): self
    {
        $this->order = [$raw];

        return $this;
    }

    /**
     * SQL limit
     *
     * @param int $limit
     *
     * @return $this
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * SQL offset
     *
     * @param int $offset
     *
     * @return $this
     */
    public function offset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * Returns current build query
     *
     * @return string
     */
    public function getQuery(): string
    {
        $query = [];

        if ($this->select) {
            $query[] = 'SELECT ' . $this->select;
        }

        if ($this->from) {
            $query[] = 'FROM ' . $this->from;
        }

        if (!empty($this->joins)) {
            $defaultFrom = $this->from;
            $query[] = implode(' ', array_map(static function ($join) use ($defaultFrom) {
                [$related, $localKey, $foreignKey, $operator, $type, $from] = $join;

                return implode(' ', [
                    $type,
                    'JOIN',
                    $related,
                    'ON',
                    ($from ?? $defaultFrom) . '.' . $localKey,
                    $operator,
                    $related . '.' . $foreignKey
                ]);
            }, $this->joins));
        }

        if (!empty($this->wheres)) {
            $wheres = implode(' ', array_map(static function ($where, $index) {
                if (count($where) === 1) {
                    return $where[0];
                }

                [$column, $operator, $value, $conditional] = $where;

                return ($index !== 0 ? $conditional . ' ' : '') . implode(' ', [$column, $operator, $value]);
            }, $this->wheres, array_keys($this->wheres)));

            $query[] = 'WHERE ' . $wheres;
        }

        if ($this->order) {
            $query[] = 'ORDER BY ' . implode(' ', $this->order);
        }

        if ($this->limit) {
            $query[] = 'LIMIT ' . $this->limit;
        }

        if ($this->offset) {
            $query[] = 'OFFSET ' . $this->offset;
        }

        return implode(' ', $query) . ';';
    }
}
