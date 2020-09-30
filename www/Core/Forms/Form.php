<?php

namespace ESGI\Core\Forms;

use ESGI\Core\Models\ModelInterface;

class Form
{
    /** @var string[] $inputs */
    private $inputs;

    /** @var array $attributes */
    private $attributes;

    public function __construct(array $inputs = [], array $attributes = [])
    {
        $this->inputs = $inputs;
        $this->attributes = $attributes;
    }

    /**
     * Add an input to current form
     *
     * @param string $input
     *
     * @return $this
     */
    public function addInput(string $input): self
    {
        $this->inputs[] = $input;

        return $this;
    }

    /**
     * Call current form and returns it
     *
     * @param string $name
     * @param ModelInterface|null $model
     *
     * @return string
     */
    public static function call(string $name, ?ModelInterface $model = null): string
    {
        /** @var callable $inputs */
        $inputs = ['ESGI\\Forms\\' . ucfirst($name) . 'Form', 'getInputs'];

        /** @var callable $configuration */
        $configuration = ['ESGI\\Forms\\' . ucfirst($name) . 'Form', 'getConfiguration'];

        return new Form($inputs($model), $configuration($model));
    }

    /**
     * Convert current form to string
     *
     * @return string
     */
    public function __toString()
    {
        $htmlAttributes = [];
        foreach ($this->attributes as $attribute => $value) {
            if (!empty($_GET['id']) && $attribute === 'action') {
                $htmlAttributes[] = $attribute . '="' . $value . '?id=' . $_GET['id'] . '"';
            } else {
                $htmlAttributes[] = $attribute . '="' . $value . '"';
            }
        }

        return '<form ' . implode(' ', $htmlAttributes) . '>' . implode(PHP_EOL, $this->inputs) . '</form>';
    }
}
