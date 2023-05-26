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

/* Personnel */
$router->addAdminRoute('intervenants', 'PersonnelController', 'intervenantsView');
$router->addAdminRoute('intervenants&page=<num>', 'PersonnelController', 'intervenantsView');

$router->addAdminRoute('intervenants&search=<query>', 'PersonnelController', 'searchIntervenantsView');
$router->addAdminRoute('plannings', 'PersonnelController', 'planningsView');
$router->addAdminRoute('notes-frais', 'PersonnelController', 'notesFraisView');
$router->addAdminRoute('emprunts', 'PersonnelController', 'empruntsVehiculesView');

$requestUrl = $_SERVER['REQUEST_URI'];
$router->handleRequest($requestUrl);