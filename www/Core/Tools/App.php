<?php

namespace ESGI\Core\Tools;

use ESGI\Core\Configuration\Config;

class App
{
    /**
     * Returns true if current application is on development mode, false otherwise
     *
     * @return bool
     */
    public static function isInDevelopmentMode(): bool
    {
        return Config::get('APP_ENV', 'production') === 'development' && !self::isInTestMode();
    }

    /**
     * Returns true if current application is on test mode, false otherwise
     *
     * @return bool
     */
    public static function isInTestMode(): bool
    {
        return defined('EXECUTE_AS_PHPUNIT');
    }
}
