<?php

namespace ESGI\Helpers;

class Icon
{
    /**
     * Returns content of a named icon (SVG format)
     *
     * @param string $name
     *
     * @return string
     */
    public static function getContent(string $name): string
    {
        $path = BASE_PATH . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'icons' . DIRECTORY_SEPARATOR . $name . '.svg';

        if (file_exists($path)) {
            return file_get_contents($path);
        }

        return '';
    }
}
