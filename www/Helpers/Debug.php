<?php

namespace ESGI\Helpers;

class Debug
{
    /** @var bool */
    private static $HIGHLIGHT_LOADED = false;

    /**
     * Debug any variable to client navigator
     *
     * @param $debug
     */
    public static function dump($debug): void
    {
        if (defined('EXECUTE_AS_PHPUNIT')) {
            var_export($debug);

            return;
        }

        if (!self::$HIGHLIGHT_LOADED) {
            echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/highlight.min.js"></script>';
            echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/languages/php.min.js"></script>';
            echo '<script>hljs.initHighlightingOnLoad();</script>';
            echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.18.1/styles/github-gist.min.css">';

            self::$HIGHLIGHT_LOADED = true;
        }

        echo '<pre><code class="language-php">';
        var_export($debug);
        echo '</code></pre>';
    }

    /**
     * Debug any variable to client navigator and stop application execution
     *
     * @param $debug
     */
    public static function dumpAndDie($debug): void
    {
        self::dump($debug);
        die();
    }
}
