<?php

namespace ESGI\Core\Autoloader;

class Autoloader
{

    /** @var string */
    private static $basePath = __DIR__;

    /** @var string|null */
    private static $firstNamespace;

    /**
     * Define base path of application
     *
     * @param string $basePath
     */
    public static function setBasePath(string $basePath): void
    {
        static::$basePath = $basePath;
    }

    /**
     * Define first namespace of application (eg: \App)
     *
     * @param string $firstNamespace
     */
    public static function setFirstNamespace(string $firstNamespace): void
    {
        static::$firstNamespace = $firstNamespace;
    }

    /**
     * Autoload any class of application
     *
     * @param string $className
     */
    public static function loader(string $className): void
    {
        $basePath = static::$basePath ?? '';

        // Decorate $className
        if (static::$firstNamespace !== null) {
            $className = str_replace(static::$firstNamespace . '\\', '', $className);

            /** @var string $className */
            $className = preg_replace('/[\/\\\\]/', DIRECTORY_SEPARATOR, $className);
        }

        $filePath = $basePath . DIRECTORY_SEPARATOR . $className . '.php';

        // Check to current base path
        if (file_exists($filePath) && is_readable($filePath)) {
            require $filePath;
        } else {
            // Check to vendor/
            $filePath = str_replace($basePath, dirname($basePath) . DIRECTORY_SEPARATOR . 'vendor', $filePath);

            if (file_exists($filePath) && is_readable($filePath)) {
                require $filePath;
            } else {
                // Re-check to current base path but with class name in lowercase
                $filePath = $basePath . DIRECTORY_SEPARATOR . strtolower($className) . '.php';

                if (file_exists($filePath) && is_readable($filePath)) {
                    require $filePath;
                }
            }
        }
    }
}
