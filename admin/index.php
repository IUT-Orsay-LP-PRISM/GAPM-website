<?php

namespace App\admin;

use App\controllers\PersonnelController;
use App\controllers\Router;

session_name('admin');
session_start();
require_once "config/bootstrap.php";
require_once "../Router.php";

global $entityManagerFactory;
$entityManager = $entityManagerFactory();

$router = new Router();
$router->addAdminRoute('login', 'PersonnelController', 'loginView');
$router->addAdminRoute('logout', 'PersonnelController', 'logoutSubmit');
$router->addAdminRoute('login-submit', 'PersonnelController', 'loginSubmit');

$requestUrl = $_SERVER['REQUEST_URI'];
$router->handleRequest($requestUrl);