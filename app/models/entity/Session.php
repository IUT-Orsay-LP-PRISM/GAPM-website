<?php

namespace App\models\entity;

abstract class Session
{

    public static function start(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE || session_start();
    }

    public static function currentSession(): array
    {
        return $_SESSION;
    }

    public static function destroy(): bool
    {
        return session_destroy();
    }

    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key)
    {
        return $_SESSION[$key];
    }


}