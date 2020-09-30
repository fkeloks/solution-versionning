<?php

namespace ESGI\Core\Validation;

use ESGI\Core\Forms\FormInterface;

class Validation
{
    /** @var FormInterface|string */
    private $form;

    /** @var array */
    private $errors = [];

    /**
     * Validation constructor.
     *
     * @param FormInterface|string $form
     */
    public function __construct($form)
    {
        $this->form = $form;
    }

    /**
     * Instantiate a new validation object
     *
     * @param FormInterface|string $form
     *
     * @return Validation
     */
    public static function create($form): self
    {
        return new self($form);
    }

    /**
     * Returns true if current validation has errors, false otherwise
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Returns current validation errors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Validate current validation rules (based on form configuration)
     *
     * @return $this
     */
    public function validate(): self
    {
        $label = '';
        foreach ($this->form::getRules() as $field => $rules) {
            if (!in_array('nullable', $rules, true) || (in_array('nullable', $rules, true) && $_POST[$field] !== '')) {
                foreach ($this->form::getLabels() as $key => $value) {
                    if ($field == $key) {
                        $label = $value;
                    }
                }

                foreach ($rules as $rule) {
                    $parameters = explode(':', $rule);
                    $method = array_shift($parameters);
                    if ($method !== 'nullable') {
                        if ($method === 'time') {
                            $parameters = array_chunk($parameters, 2);
                            $parameters[0] = implode(':', $parameters[0]);
                            $parameters[1] = implode(':', $parameters[1]);
                        }

                        if (count($parameters) === 1) {
                            $parameters = $parameters[0];
                        }

                        $error = call_user_func([ValidationRule::class, $method], $label, $field, $parameters);
                        if ($error !== null) {
                            $this->errors[] = $error;
                        }
                    }
                }
            }
        }

        return $this;
    }
}
