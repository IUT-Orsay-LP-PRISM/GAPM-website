<?php

namespace App\controllers;

abstract class SearchController implements InterfaceController
{
    public static function index()
    {
        require_once "app/views/search.php";
        var_dump($_GET);

    }

}