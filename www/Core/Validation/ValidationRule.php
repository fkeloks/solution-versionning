<?php

namespace ESGI\Core\Validation;

class ValidationRule
{
    /**
     * Required rule
     *
     * @param string $label
     * @param string $field
     *
     * @return string|null
     */
    public static function required(string $label, string $field): ?string
    {
        if (empty($_POST[$field]) && $_POST[$field] != '0') {
            return 'Le champ <i>' . $label . '</i> est obligatoire';
        }

        return null;
    }

    /**
     * Minimum rule
     *
     * @param string $label
     * @param string $field
     * @param int $min
     *
     * @return string|null
     */
    public static function min(string $label, string $field, int $min): ?string
    {
        if ($field === 'number' || $field === 'surface' || $field === 'price' || $field === 'salary') {
            if ((float)$_POST[$field] <= $min) {
                return 'Le champ <i>' . $label . '</i> doit être supérieur à ' . $min;
            }
        } elseif (strlen($_POST[$field]) < $min) {
            return 'Le champ <i>' . $label . '</i> doit faire plus de ' . $min . ' caractères';
        }

        return null;
    }

    /**
     * Maximum rule
     *
     * @param string $label
     * @param string $field
     * @param int $max
     *
     * @return string|null
     */
    public static function max(string $label, string $field, int $max): ?string
    {
        if ($field === 'number' || $field === 'surface' || $field === 'price') {
            if ((float)$_POST[$field] > $max) {
                return 'Le champ <i>' . $label . '</i> doit être inférieur à ' . $max;
            }
        } elseif (strlen($_POST[$field]) > $max) {
            return 'Le champ <i>' . $label . '</i> doit faire moins de ' . $max . ' caractères';
        }

        return null;
    }

    /**
     * In array rule
     *
     * @param string $label
     * @param string $field
     * @param array $in
     *
     * @return string|null
     */
    public static function in(string $label, string $field, array $in): ?string
    {
        if (!in_array($_POST[$field], $in, true)) {
            return 'Le champ <i>' . $label . '</i> n\'est pas valide';
        }

        return null;
    }

    /**
     * Date rule
     *
     * @param string $label
     * @param string $field
     * @param array $date
     *
     * @return string|null
     */
    public static function date(string $label, string $field, array $date): ?string
    {
        if ($date[0] > $date[1]) {
            return 'Les champs dates sont invalides';
        }

        return null;
    }

    /**
     * Time rule
     *
     * @param string $label
     * @param string $field
     * @param array $time
     *
     * @return string|null
     */
    public static function time(string $label, string $field, array $time): ?string
    {
        if (($_POST['date_start'] === $_POST['date_end']) && $time[0] > $time[1]) {
            return 'Les champs heures sont invalides';
        }

        return null;
    }

    /**
     * Email rule
     *
     * @param string $label
     * @param string $field
     *
     * @return string|null
     */
    public static function email(string $label, string $field): ?string
    {
        if (!empty($_POST[$field]) && !filter_var($_POST[$field], FILTER_VALIDATE_EMAIL)) {
            return 'Le champ <i>' . $label . '</i> est invalide';
        }

        return null;
    }

    /**
     * Password & password confirmation rule
     *
     * @param string $label
     * @param string $field
     *
     * @return string|null
     */
    public static function password(string $label, string $field): ?string
    {
        if ($_POST['password_confirm'] !== $_POST['password']) {
            return 'Les champs <i>' . $label . '</i> ne correspondent pas';
        }

        return null;
    }
}
