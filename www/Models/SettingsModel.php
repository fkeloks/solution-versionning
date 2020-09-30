<?php

namespace ESGI\Models;

class SettingsModel extends Model
{
    /** @var string $label */
    protected $label;

    /** @var string $key */
    protected $key;

    /** @var string $value */
    protected $value;

    /** @var string|null $options */
    protected $options;

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return SettingsModel
     */
    public function setLabel(string $label): SettingsModel
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return SettingsModel
     */
    public function setKey(string $key): SettingsModel
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return SettingsModel
     */
    public function setValue(string $value): SettingsModel
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getOptions(): ?array
    {
        if ($this->options === null) {
            return null;
        }

        return json_decode($this->options, true);
    }

    /**
     * @param string $options
     * @return SettingsModel
     */
    public function setOptions(string $options): SettingsModel
    {
        $this->options = $options;

        return $this;
    }
}
