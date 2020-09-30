<?php

namespace ESGI\Models;

use ESGI\Core\Models\ManageableModel;
use ESGI\Core\Models\ModelInterface;
use ESGI\Core\Models\HydratableModel;
use ESGI\Core\Models\QueryableModel;

class Model implements ModelInterface
{
    use HydratableModel, QueryableModel, ManageableModel;

    /** @var int $id */
    protected $id;

    /** @var string[] */
    protected static $searchableColumns = [];

    /**
     * Returns current model ID
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns table name of current model
     *
     * @return string
     */
    public static function getTableName(): string
    {
        $className = str_replace(__NAMESPACE__ . '\\', '', static::class);
        $className = preg_replace('/\B([A-Z])/', '_$1', $className);
        $className = preg_replace('/_model$/', '', strtolower($className));

        return $className ?? '';
    }

    /**
     * Returns attribute of current model
     *
     * @param string $attribute
     *
     * @return mixed
     */
    public function getAttribute(string $attribute)
    {
        return $this->$attribute;
    }

    /**
     * Returns attributes of current model
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return array_filter(get_object_vars($this), static function ($attribute) {
            return $attribute !== null && !is_array($attribute) && !($attribute instanceof ModelInterface);
        });
    }
}
