<?php

namespace App\controllers;

class Route
{
    public static function get(string $str, string $controller, string $action)
    {
        $url = $_SERVER['REQUEST_URI'];
        if ($str === $url){
            $controller = "App\\controllers\\".$controller;
            $controller::$action();
        }
    }

    public static function search(string $str)
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('&', $url);
        if ($url[0] == $str){
            $controller = "App\\controllers\\SearchController";
            $controller::index();
        }
    }

    public static function autocomplete(string $str, string $controller)
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('&', $url);
        if ($url[0] == $str){
            $controller = "App\\controllers\\".$controller."Controller";
            $controller::autocomplete();
        }
    }

    public static function post()
    {
        /**
         * TODO: Faire le système d'implémentation pour les formulaires, récupérés les valeurs etc..
         * TODO: Faire le système de vérification des données
         */
    }

    public static function notFound()
    {
        $url = $_SERVER['REQUEST_URI'];
        if ($url != '/'){
            header('Location: /app/views/404.html');
        } else {
            header('Location: /');
        }
    }

}