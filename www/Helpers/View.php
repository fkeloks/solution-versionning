<?php

namespace ESGI\Helpers;

use ESGI\Core\Tools\DebugBar;

class View
{
    /**
     * Returns path of an view
     *
     * @param string $view
     *
     * @return string
     */
    public static function getPath(string $view): string
    {
        $view = str_replace('.', DIRECTORY_SEPARATOR, $view);

        return BASE_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view . '.php';
    }

    /**
     * Returns content of an view
     *
     * @param string $view
     * @param array $params
     *
     * @return string
     */
    public static function getContent(string $view, array $params = []): string
    {
        $path = self::getPath($view);

        if (file_exists($path)) {
            DebugBar::addEntry('views', $view, true);

            ob_start();
            extract($params, EXTR_OVERWRITE);
            include $path;

            return ob_get_clean();
        }

        return '';
    }
}
