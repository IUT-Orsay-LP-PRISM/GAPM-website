<?php

namespace App\controllers;

class Route
{
    public static function get(string $str, string $controller, string $action)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === $str) {
            $controller = "App\\controllers\\{$controller}";
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

    public static function post(string $str, string $controller, string $action)
    {
        $url = $_GET['action'];
        if ($str === $url){
            $controller = "App\\controllers\\".$controller;
            $controller::$action();
        }
    }

}