<?php

namespace App\controllers;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Setup;

class Route
{
    public static function get(string $action, string $controller, string $method)
    {
        $isDevMode = true;
        $config = ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/app'], $isDevMode);
        $connectionParams = [
            'dbname' => 'gapm',
            'user' => 'root',
            'password' => 'root',
            'host' => 'mariadb',
            'driver' => 'pdo_mysql',
        ];

        $connection = DriverManager::getConnection($connectionParams, $config);
        $entityManager = new EntityManager($connection, $config);

        if (isset($_GET['action'])) {
            if ($action === $_GET['action']) {
                $controller = "App\\controllers\\" . $controller;
                $controller = new $controller($entityManager);
                $controller->$method();
            }
        } else {
            $_GET['action'] = 'home';
            HomeController::index();
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