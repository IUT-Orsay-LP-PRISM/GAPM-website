<?php

namespace App\controllers;

class Route
{
    public static function get(string $action, string $controller, string $method)
    {
        global $entityManager;

        if (isset($_GET['action'])) {
            if ($action === $_GET['action']) {
                $controller = "App\\controllers\\" . $controller;
                $controller = new $controller($entityManager);
                $controller->$method();
            }
        } else {
            $_GET['action'] = 'home';
            $controller = "App\\controllers\\HomeController";
            $controller = new $controller($entityManager);
            $controller->index();
        }
    }

    public static function search(string $str)
    {
        global $entityManager;

        $url = $_SERVER['REQUEST_URI'];
        $url = explode('&', $url);
        if ($url[0] == $str) {
            $controller = "App\\controllers\\SearchController";
            $controller = new $controller($entityManager);
            $controller->index();
        }
    }

    public static function autocomplete(string $str, string $controller)
    {
        global $entityManager;

        $url = $_SERVER['REQUEST_URI'];
        $url = explode('&', $url);
        if ($url[0] == $str) {
            $controller = "App\\controllers\\" . $controller . "Controller";
            $controller = new $controller($entityManager);
            $controller->autocomplete();
        }
    }

    public static function post(string $action, string $controller, string $method)
    {
        global $entityManager;

        if (isset($_GET['action'])) {
            if ($action === $_GET['action']) {
                $controller = "App\\controllers\\" . $controller;
                $controller = new $controller($entityManager);
                $controller->$method();
            }
        }
    }

}