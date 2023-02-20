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

    public static function destroy(): void
    {
        session_unset();
        session_destroy();
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