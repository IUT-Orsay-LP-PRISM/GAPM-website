<?php

namespace App\admin;

use App\controllers\Router;

session_name('admin');
session_start();
require_once "config/bootstrap.php";
require_once "../Router.php";

global $entityManagerFactory;
$entityManager = $entityManagerFactory();

$router = new Router();
$router->addAdminRoute('login', 'PersonnelController', 'login');

$requestUrl = $_SERVER['REQUEST_URI'];
$router->handleRequest($requestUrl);