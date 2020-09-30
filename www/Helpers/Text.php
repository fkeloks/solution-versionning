<?php

namespace ESGI\Helpers;

class Text
{
    /**
     * Convert a value to studly caps case.
     *
     * @param string $text
     *
     * @return string
     */
    public static function studly(string $text): string
    {
        $text = ucwords(str_replace(['-', '_'], ' ', $text));

        return str_replace(' ', '', $text);
    }

    /**
     * Pluralize an text
     *
     * @param string $singular
     *
     * @return string
     */
    public static function pluralize(string $singular): string
    {
        if ($singular === '') {
            return $singular;
        }

        $lastLetter = strtolower($singular[strlen($singular) - 1]);
        switch ($lastLetter) {
            case 'y':
                return substr($singular, 0, -1) . 'ies';
            case 's':
                return $singular . 'es';
            default:
                return $singular . 's';
        }
    }

    /**
     * Singularize an text
     *
     * @param string $plural
     *
     * @return string
     */
    public static function singularize(string $plural): string
    {
        $singular = [
            '/(quiz)zes$/i' => '\\1',
            '/(matr)ices$/i' => '\\1ix',
            '/(vert|ind)ices$/i' => '\\1ex',
            '/^(ox)en/i' => '\\1',
            '/(alias|status)es$/i' => '\\1',
            '/([octop|vir])i$/i' => '\\1us',
            '/(cris|ax|test)es$/i' => '\\1is',
            '/(shoe)s$/i' => '\\1',
            '/(o)es$/i' => '\\1',
            '/(bus)es$/i' => '\\1',
            '/([m|l])ice$/i' => '\\1ouse',
            '/(x|ch|ss|sh)es$/i' => '\\1',
            '/(m)ovies$/i' => '\\1ovie',
            '/(s)eries$/i' => '\\1eries',
            '/([^aeiouy]|qu)ies$/i' => '\\1y',
            '/([lr])ves$/i' => '\\1f',
            '/(tive)s$/i' => '\\1',
            '/(hive)s$/i' => '\\1',
            '/([^f])ves$/i' => '\\1fe',
            '/(^analy)ses$/i' => '\\1sis',
            '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\\1\\2sis',
            '/([ti])a$/i' => '\\1um',
            '/(n)ews$/i' => '\\1ews',
            '/s$/i' => ''
        ];

        $irregular = [
            'person' => 'people',
            'man' => 'men',
            'child' => 'children',
            'sex' => 'sexes',
            'move' => 'moves'
        ];

        $ignore = [
            'equipment',
            'information',
            'rice',
            'money',
            'species',
            'series',
            'fish',
            'sheep',
            'press',
            'sms',
        ];

        $lower_word = strtolower($plural);
        foreach ($ignore as $ignore_word) {
            if (substr($lower_word, (-1 * strlen($ignore_word))) === $ignore_word) {
                return $plural;
            }
        }

        foreach ($irregular as $singular_word => $plural_word) {
            if (preg_match('/(' . $plural_word . ')$/i', $plural, $arr)) {
                $pattern = '/(' . $plural_word . ')$/i';
                $replacement = substr($arr[0], 0, 1) . substr($singular_word, 1);

                return preg_replace($pattern, $replacement, $plural);
            }
        }

        foreach ($singular as $rule => $replacement) {
            if (preg_match($rule, $plural)) {
                /** @var string $match */
                $match = preg_replace($rule, $replacement, $plural);

                return $match;
            }
        }

        return $plural;
    }
}
