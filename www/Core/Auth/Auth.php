<?php

namespace ESGI\Core\Auth;

use ESGI\Models\UsersModel;

class Auth
{
    /**
     * Returns true if user has logged in, false otherwise
     *
     * @return bool
     */
    public static function isLogged(): bool
    {
        return !empty($_SESSION) && array_key_exists('auth', $_SESSION) && $_SESSION['auth'] === true;
    }

    /**
     * Returns current logged user
     *
     * @return UsersModel|null
     */
    public static function getUser(): ?UsersModel
    {
        if (self::isLogged()) {
            return $_SESSION['user'];
        }

        return null;
    }

    /**
     * Connect a given user
     *
     * @param UsersModel $user
     */
    public static function login(UsersModel $user): void
    {
        $_SESSION['auth'] = true;
        $_SESSION['user'] = $user;
    }

    /**
     * Disconnect current logged in user
     */
    public static function logout(): void
    {
        $_SESSION['auth'] = false;
        unset($_SESSION['user']);
    }
}
