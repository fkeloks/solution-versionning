<?php

namespace ESGI\Core\Models;

trait HydratableModel
{
    /**
     * Hydrate a model with database datas
     *
     * @param ModelInterface|string $model
     * @param array $attributes
     *
     * @return ModelInterface
     */
    public static function hydrate($model, array $attributes): ModelInterface
    {
        if (!($model instanceof ModelInterface)) {
            /** @var ModelInterface $model */
            $model = new $model;
        }

        foreach ($attributes as $name => $value) {
            if (is_string($name)) {
                if (strpos($name, '.')) {
                    [$table, $column] = explode('.', $name);
                } else {
                    $table = $model::getTableName();
                    $column = $name;
                }

                if (property_exists($model, $column) && $table === $model::getTableName()) {
                    $model->$column = $value;
                }

                // Model relations support
                $relatedModel = singularize($table);
                if (property_exists($model, $relatedModel) && method_exists($model, 'get' . ucfirst($relatedModel))) {
                    $hasRelatedModel = array_key_exists($table . '.id', $attributes)
                        && $attributes[$table . '.id'] !== null;

                    if ($hasRelatedModel) {
                        if (!$model->$relatedModel instanceof ModelInterface) {
                            $relatedModelClassName = '\ESGI\Models\\' . ucfirst($table) . 'Model';
                            $model->$relatedModel = new $relatedModelClassName;
                        }

                        // Related model hydratation
                        if (property_exists($model->$relatedModel, $column)) {
                            $model->$relatedModel->$column = $value;
                        }
                    }
                }
            }
        }

        return $model;
    }

    /**
     * Hydrate a collection of models
     *
     * @param string $model
     * @param array $rows
     *
     * @return ModelInterface[]
     */
    public static function hydrateRows(string $model, array $rows): array
    {
        return array_map(static function ($attributes) use ($model) {
            return static::hydrate($model, $attributes);
        }, $rows);
    }
}
