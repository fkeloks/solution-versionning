<?php

namespace ESGI\Core\Configuration;

class Config
{
    /** @var array $items */
    private static $items = [];

    /**
     * Put an item to configuration
     *
     * @param string $key
     * @param mixed $value
     */
    public static function set(string $key, $value): void
    {
        self::$items[$key] = $value;
    }

    /**
     * Determine if an item is on configuration
     *
     * @param string $key
     *
     * @return bool
     */
    public static function has(string $key): bool
    {
        return array_key_exists($key, self::$items);
    }

    /**
     * Retrieve an item from configuration
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed|null
     */
    public static function get(string $key, $default = null)
    {
        return self::has($key) ? self::$items[$key] : $default;
    }

    /**
     * Returns all items from configuration
     *
     * @return array
     */
    public static function all(): array
    {
        return self::$items;
    }
}
