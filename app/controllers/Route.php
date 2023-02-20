<?php

namespace App\controllers;

class Route
{
    public static function get(string $action, string $controller, string $method)
    {
        if (isset($_GET['action'])) {
            if ($action === $_GET['action']) {
                $controller = "App\\controllers\\" . $controller;
                $controller::$method();
            }
        } else {
            $_GET['action'] = '/';
            $controller = "App\\controllers\\HomeController";
            $controller::index();
        }
    }

    public static function search(string $str)
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('&', $url);
        if ($url[0] == $str) {
            $controller = "App\\controllers\\SearchController";
            $controller::index();
        }
    }

    public static function autocomplete(string $str, string $controller)
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('&', $url);
        if ($url[0] == $str) {
            $controller = "App\\controllers\\" . $controller . "Controller";
            $controller::autocomplete();
        }
    }

    public static function post(string $action, string $controller, string $method)
    {
        if (isset($_GET['action'])) {
            if ($action === $_GET['action']) {
                $controller = "App\\controllers\\" . $controller;
                $controller::$method();
            }
        }
    }

}