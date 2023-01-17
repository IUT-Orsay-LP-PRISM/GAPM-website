<?php

namespace App\models\entity;

abstract class Session
{

    public static function start(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE || session_start();
    }

    public static function currentSession()
    {


    }
}