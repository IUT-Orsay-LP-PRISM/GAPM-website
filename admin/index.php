<?php

namespace App\admin;

use App\controllers\Router;

require_once "config/bootstrap.php";
require_once "../Router.php";

session_name('admin');
session_start();

global $entityManagerFactory;
$entityManager = $entityManagerFactory();

$router = new Router();
$router->addAdminRoute('login', 'PersonnelController', 'loginView');
$router->addAdminRoute('logout', 'PersonnelController', 'logoutSubmit');
$router->addAdminRoute('login-submit', 'PersonnelController', 'loginSubmit');

/* Intervenants */
$router->addAdminRoute('intervenants', 'PersonnelController', 'intervenantsView');
$router->addAdminRoute('intervenants&page=<num>', 'PersonnelController', 'intervenantsView');
$router->addAdminRoute('intervenants&search=<query>', 'PersonnelController', 'searchIntervenantsView');
$router->addAdminRoute('intervenant&id=<id>', 'PersonnelController', 'intervenantView');
$router->addAdminRoute('intervenant-edit&id=<id>', 'PersonnelController', 'editIntervenantView');
$router->addAdminRoute('intervenant-delete&id=<id>', 'PersonnelController', 'deleteIntervenantView');
$router->addAdminRoute('update-intervenant', 'IntervenantController', 'updateFromAdmin');
$router->addAdminRoute('delete-intervenant', 'PersonnelController', 'deleteIntervenantSubmit');

/* Demandeurs */
$router->addAdminRoute('demandeurs', 'PersonnelController', 'demandeursView');
$router->addAdminRoute('demandeurs&page=<num>', 'PersonnelController', 'demandeursView');
$router->addAdminRoute('demandeurs&search=<query>', 'PersonnelController', 'searchDemandeursView');
$router->addAdminRoute('demandeur&id=<id>', 'PersonnelController', 'demandeurView');
$router->addAdminRoute('demandeur-edit&id=<id>', 'PersonnelController', 'editDemandeurView');
$router->addAdminRoute('demandeur-delete&id=<id>', 'PersonnelController', 'deleteDemandeurView');
$router->addAdminRoute('update-demandeur', 'PersonnelController', 'updateDemandeurSubmit');
$router->addAdminRoute('delete-demandeur', 'PersonnelController', 'deleteDemandeurSubmit');

/* Notes de frais */
$router->addAdminRoute('notes-frais', 'PersonnelController', 'notesFraisView');
$router->addAdminRoute('note-frais&id=<id>', 'PersonnelController', 'noteFraisOneView');
$router->addAdminRoute('validate-notefrais', 'PersonnelController', 'notesFraisValidateSubmit');
$router->addAdminRoute('refuse-notefrais', 'PersonnelController', 'notesFraisDeniedSubmit');

/* Emprunts */
$router->addAdminRoute('emprunts', 'PersonnelController', 'empruntsVehiculesView');
$router->addAdminRoute('validate-emprunt', 'PersonnelController', 'empruntsVehiculesValidateSubmit');
$router->addAdminRoute('denied-emprunt', 'PersonnelController', 'empruntsVehiculesDeniedSubmit');

$router->addAdminRoute('cessation', 'PersonnelController', 'cessationView');
$router->addAdminRoute('validate-cessation', 'PersonnelController', 'validateCessationSubmit');
$router->addAdminRoute('demande', 'PersonnelController', 'demandeIntervenantView');

$router->addAdminRoute('autocompleteSpecialite&query<query>', 'SpecialiteController', 'autocomplete');
$router->addAdminRoute('autocompleteVille&query=<query>', 'VilleController', 'autocomplete');

$requestUrl = $_SERVER['REQUEST_URI'];
$router->handleRequest($requestUrl);