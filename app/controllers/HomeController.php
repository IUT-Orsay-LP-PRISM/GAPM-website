<?php

namespace App\controllers;

abstract class HomeController implements InterfaceController
{
    public static function index()
    {
        require_once "app/views/home.php";
    }
}