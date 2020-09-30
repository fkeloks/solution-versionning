<?php

namespace ESGI\Core\Forms;

use ESGI\Core\Models\ModelInterface;

interface FormInterface
{
    /**
     * Define form configuration
     *
     * @param ModelInterface|null $model
     *
     * @return array
     */
    public static function getConfiguration(?ModelInterface $model = null): array;

    /**
     * Define inputs of form
     *
     * @param ModelInterface|null $model
     *
     * @return array
     */
    public static function getInputs(?ModelInterface $model = null): array;

    /**
     * Define rules of form (based on configured inputs)
     *
     * @return array
     */
    public static function getRules(): array;

    /**
     * Define labels of form (based on configured inputs)
     *
     * @return array
     */
    public static function getLabels(): array;
}
