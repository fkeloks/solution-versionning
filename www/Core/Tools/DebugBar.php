<?php

namespace ESGI\Core\Tools;

class DebugBar
{
    /** @var array */
    private static $STORAGE = [];

    /**
     * Add an entry to DebugBar component
     *
     * @param string $name
     * @param string $entry
     * @param bool $list
     */
    public static function addEntry(string $name, string $entry, bool $list = false): void
    {
        if (App::isInDevelopmentMode()) {
            $name = ucfirst($name);

            if (!array_key_exists($name, self::$STORAGE)) {
                self::$STORAGE[$name] = [];
            }

            if ($list) {
                self::$STORAGE[$name][] = $entry;
            } else {
                self::$STORAGE[$name] = $entry;
            }

            ksort(self::$STORAGE);

            if (!headers_sent()) {
                // Store current entries to client cookies
                setcookie('DEBUG_BAR_ENTRIES', json_encode(self::$STORAGE), time() + 60);
            }
        }
    }

    /**
     * Returns all DebugBar entries
     *
     * @return array
     */
    public static function getEntries(): array
    {
        return self::$STORAGE;
    }
}
