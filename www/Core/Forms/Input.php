<?php

namespace ESGI\Core\Forms;

use ESGI\Core\Database\QueryBuilder;
use ESGI\Core\Models\ModelInterface;
use ESGI\Helpers\Text;

class Input
{
    /** @var string */
    public static $HTML_WRAPPER_START = '<div class="form-group">';

    /** @var string */
    public static $HTML_WRAPPER_END = '</div>';

    /** @var string */
    public static $HTML_INPUT_CLASS = '';

    /**
     * Returns a text input
     *
     * @param string $name
     * @param ModelInterface|null $model
     * @param array $attributes
     *
     * @return string
     */
    public static function text(string $name, ?ModelInterface $model, array $attributes): string
    {
        return static::input($name, 'text', $model, $attributes);
    }

    /**
     * Returns a email input
     *
     * @param string $name
     * @param ModelInterface|null $model
     * @param array $attributes
     *
     * @return string
     */
    public static function email(string $name, ?ModelInterface $model = null, array $attributes = []): string
    {
        return static::input($name, 'email', $model, $attributes);
    }

    /**
     * Returns a telephone input
     *
     * @param string $name
     * @param ModelInterface|null $model
     * @param array $attributes
     *
     * @return string
     */
    public static function tel(string $name, ?ModelInterface $model = null, array $attributes = []): string
    {
        return static::input($name, 'tel', $model, $attributes);
    }

    /**
     * Returns a number input
     *
     * @param string $name
     * @param ModelInterface|null $model
     * @param array $attributes
     *
     * @return string
     */
    public static function number(string $name, ?ModelInterface $model = null, array $attributes = []): string
    {
        return static::input($name, 'number', $model, $attributes);
    }

    /**
     * Returns a date input
     *
     * @param string $name
     * @param ModelInterface|null $model
     * @param array $attributes
     *
     * @return string
     */
    public static function date(string $name, ?ModelInterface $model = null, array $attributes = []): string
    {
        return static::input($name, 'date', $model, $attributes);
    }

    /**
     * Returns a time input
     *
     * @param string $name
     * @param ModelInterface|null $model
     * @param array $attributes
     *
     * @return string
     */
    public static function time(string $name, ?ModelInterface $model = null, array $attributes = []): string
    {
        return static::input($name, 'time', $model, $attributes);
    }

    /**
     * Returns a password input
     *
     * @param string $name
     * @param ModelInterface|null $model
     * @param array $attributes
     *
     * @return string
     */
    public static function password(string $name, ?ModelInterface $model = null, array $attributes = []): string
    {
        return static::input($name, 'password', $model, $attributes);
    }

    /**
     * Returns a submit input
     *
     * @param string $name
     * @param array $attributes
     *
     * @return string
     */
    public static function submit(string $name, array $attributes = []): string
    {
        return static::button($name, $attributes);
    }

    /**
     * Returns a textarea input
     *
     * @param string $name
     * @param ModelInterface|null $model
     * @param array $attributes
     *
     * @return string
     */
    public static function textarea(string $name, ?ModelInterface $model = null, array $attributes = []): string
    {
        return static::input($name, 'textarea', $model, $attributes);
    }

    /**
     * Returns a checkbox input
     *
     * @param string $name
     * @param array $attributes
     *
     * @return string
     */
    public static function checkbox(string $name, array $attributes = []): string
    {
        $html = '<input type="checkbox" id="' . $name . '" name="' . $name . '" ' . ($attributes['checked'] ?? false ? 'checked' : '') . '>';
        $html .= '<label for="' . $name . '">' . ($attributes['label'] ?? '') . '</label>';

        return '<div class="form-group form-group-checkbox full-width">' . $html . static::$HTML_WRAPPER_END;
    }

    /**
     * Returns a wysiwyg editor
     *
     * @param string $name
     * @param ModelInterface|null $model
     * @param array $attributes
     *
     * @return string
     */
    public static function wysiwyg(string $name, ?ModelInterface $model = null, array $attributes = []): string
    {
        return static::input($name, 'wysiwyg', $model, $attributes);
    }

    /**
     * Returns a file editor
     *
     * @param string $name
     * @param ModelInterface|null $model
     * @param array $attributes
     *
     * @return string
     */
    public static function file(string $name, ?ModelInterface $model = null, array $attributes = []): string
    {
        return static::input($name, 'file', $model, $attributes);
    }

    /**
     * Returns a html separator (HR tag)
     *
     * @return string
     */
    public static function separator(): string
    {
        return '<hr>';
    }

    /**
     * Returns a select field
     *
     * @param string $name
     * @param ModelInterface|null $model
     * @param array $attributes
     * @param array $options
     *
     * @return string
     */
    public static function select(
        string $name,
        ?ModelInterface $model = null,
        array $attributes = [],
        array $options = []
    ): string {
        return static::option($name, $model, $attributes, $options);
    }

    /**
     * Returns a select field with a database related table
     *
     * @param string $name
     * @param ModelInterface|ModelInterface[]|string $related
     * @param string|callable $relatedLabel
     * @param ModelInterface|null $model
     * @param array $attributes
     *
     * @return string
     */
    public static function relation(
        string $name,
        $related,
        $relatedLabel,
        ?ModelInterface $model = null,
        array $attributes = []
    ): string {
        $options = [];
        $queryBuilder = null;

        if (is_string($relatedLabel)) {
            $queryBuilder = (new QueryBuilder)->order($relatedLabel);
        }

        $relatedObjects = is_array($related) ? $related : $related::fetchAll($queryBuilder);
        foreach ($relatedObjects as $relatedObject) {
            if (is_string($relatedLabel)) {
                $method = 'get' . Text::studly($relatedLabel);
                if (method_exists($relatedObject, $method)) {
                    $options[$relatedObject->getId()] = $relatedObject->$method();
                }
            } elseif (is_callable($relatedLabel)) {
                // Static callback
                $options[$relatedObject->getId()] = $relatedLabel($relatedObject);
            }
        }

        // Nullable select
        if (array_key_exists('nullable', $attributes)) {
            $options[''] = $attributes['nullable'];
        }

        ksort($options);

        return static::option($name, $model, $attributes, $options);
    }

    /**
     * Returns a input field
     *
     * @param string $name
     * @param string $type
     * @param ModelInterface|null $model
     * @param array $attributes
     *
     * @return string
     */
    private static function input(
        string $name,
        string $type,
        ?ModelInterface $model = null,
        array $attributes = []
    ): string {
        $attributes = array_merge_recursive([
            'type' => $type,
            'name' => $name,
            'id' => $name,
            'class' => static::$HTML_INPUT_CLASS,
            'required' => 'required'
        ], $attributes);

        // Required option
        if (is_array($attributes['required'])) {
            unset($attributes['required']);
        }

        $content = '';
        if ($model instanceof ModelInterface && property_exists($model, $name)) {
            $value = $model->getAttribute($name);

            // Textarea & passwords fields
            if ($type === 'textarea') {
                $content = $value;
            } elseif ($type !== 'password' && $type !== 'file') {
                $attributes['value'] = $value;
            }
        }

        $htmlAttributes = [];
        foreach ($attributes as $attribute => $value) {
            $htmlAttributes[] = $attribute . '="' . $value . '"';
        }

        $html = '';
        if (array_key_exists('label', $attributes)) {
            $html .= '<label for="' . $name . '">' . $attributes['label'] . '</label>';
        }

        if ($type === 'wysiwyg') {
            $html .= view('parts.editor', [
                'name' => $name,
                'value' => $attributes['value'] ?? '',
                'type' => 'wysiwyg'
            ]);
        } else {
            $html .= '<'
                . ($type === 'textarea' ? 'textarea ' : 'input ')
                . implode(' ', $htmlAttributes) . ($type === 'textarea' ? '>' . $content . '</textarea>' : '>');
        }

        return static::$HTML_WRAPPER_START . $html . static::$HTML_WRAPPER_END;
    }

    /**
     * Returns a button
     *
     * @param string $name
     * @param array $attributes
     *
     * @return string
     */
    private static function button(string $name, array $attributes = []): string
    {
        $htmlAttributes = [];
        foreach ($attributes as $attribute => $value) {
            $htmlAttributes[] = $attribute . '="' . $value . '"';
        }

        return '<input type="submit" value="' . $name . '" ' . implode(' ', $htmlAttributes) . '>';
    }

    /**
     * Returns a option field
     *
     * @param string $name
     * @param ModelInterface|null $model
     * @param array $attributes
     * @param array $options
     *
     * @return string
     */
    private static function option(
        string $name,
        ?ModelInterface $model = null,
        array $attributes = [],
        array $options = []
    ): string {
        $selectOptions = [];

        $modelValue = -1;
        if ($model instanceof ModelInterface && property_exists($model, $name)) {
            $modelValue = $model->getAttribute($name);
        }

        foreach ($options as $value => $option) {
            $selected = $value == $modelValue;
            $selectOptions[] = '<option value="' . $value . '"' . ($selected ? ' selected>' : '>') . $option . '</option>';
        }

        if (empty($selectOptions)) {
            $selectOptions[] = '<option value="" disabled>Aucune option ne semble disponible...</option>';
        }

        $html = '';
        if (array_key_exists('label', $attributes)) {
            $html .= '<label for="' . $name . '">' . $attributes['label'] . '</label>';
        }

        $html .= '<select name="' . $name . '" id="' . $name . '">' . implode('\n', $selectOptions) . '</select>';

        return static::$HTML_WRAPPER_START . $html . static::$HTML_WRAPPER_END;
    }
}
