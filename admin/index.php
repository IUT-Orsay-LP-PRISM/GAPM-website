<?php

namespace App\admin;

use App\controllers\Router;

session_start();
require_once "config/bootstrap.php";
require_once "../Router.php";

global $entityManagerFactory;
$entityManager = $entityManagerFactory();

$router = new Router();
$router->addAdminRoute('login-pro', 'PersonnelController', 'index');

$requestUrl = $_SERVER['REQUEST_URI'];
$router->handleRequest($requestUrl);