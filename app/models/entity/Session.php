<?php

namespace App\models\entity;

abstract class Session
{

    public static function start(): bool
    {
        return session_start();
    }

    public static function currentSession(): array
    {
        return $_SESSION;
    }
    public static function destroy($user = true): void
    {
        if ($user) {
            unset($_SESSION['user']);
        } else {
            unset($_SESSION['admin']);
        }
    }

    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function isLogged(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function isLoggedAdmin(): bool
    {
        return isset($_SESSION['admin']);
    }

}