<?php

namespace ESGI\Core\Tools;

use ESGI\Helpers\Text;

class Cache
{
    /**
     * Store & retrieve any item from cache system
     *
     * @param string $key
     * @param callable $value
     * @param int $seconds
     *
     * @return mixed
     */
    public static function remember(string $key, callable $value, int $seconds = 3600)
    {
        $cacheFile = self::getCachePath() . DIRECTORY_SEPARATOR . strtolower(Text::studly($key)) . '.txt';

        if (file_exists($cacheFile) && is_readable($cacheFile)) {
            $value = unserialize(file_get_contents($cacheFile), ['allowed_classes' => true]);

            if ((time() - filemtime($cacheFile)) > $seconds) {
                unlink($cacheFile);
            }

            return $value;
        }

        $value = $value();
        file_put_contents($cacheFile, serialize($value));

        return $value;
    }

    /**
     * Remove an item from cache
     *
     * @param string $key
     */
    public static function forget(string $key): void
    {
        $cacheFile = self::getCachePath() . DIRECTORY_SEPARATOR . strtolower(Text::studly($key)) . '.txt';
        if (file_exists($cacheFile) && is_readable($cacheFile)) {
            unlink($cacheFile);
        }
    }

    /**
     * Returns cache path
     *
     * @return string
     */
    private static function getCachePath(): string
    {
        return BASE_PATH . DIRECTORY_SEPARATOR . 'cache';
    }
}
