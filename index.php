<?php

use App\controllers\Router;
use App\models\entity\Session;


require_once "Router.php";
require_once 'vendor/autoload.php';
require_once 'config/bootstrap.php';

Session::start();

global $entityManagerFactory;
$entityManager = $entityManagerFactory();
$router = new Router();

/*
 * Routes GET
 */
$router->addRoute('demandeur', 'DemandeurController', 'index');
$router->addRoute('search', 'SearchController', 'index');
$router->addRoute('logout', 'DemandeurController', 'logout');
$router->addRoute('my-account', 'DemandeurController', 'displayMyAccount');
$router->addRoute('inscription-intervenant', 'IntervenantController', 'index');
$router->addRoute('notes-de-frais', 'NoteFraisController', 'displayNoteFrais');
$router->addRoute('mes-rendez-vous', 'RendezVousController', 'displayMyRdv');
$router->addRoute('liste-rdv', 'RendezVousController', 'displayMyRdvIntervenant');

/*
 * Routes POST
 */
$router->addRoute('login', 'DemandeurController', 'login');
$router->addRoute('register', 'DemandeurController', 'register');
$router->addRoute('my-account-edit', 'DemandeurController', 'update');
$router->addRoute('my-account-delete', 'DemandeurController', 'delete');
$router->addRoute('confirm-rdv', 'RendezVousController', 'createRDV');
$router->addRoute('ajout-avis', 'RendezVousController', 'createNoticeOnRdv');
$router->addRoute('upgrade-to-intervenant', 'IntervenantController', 'devenirIntervenant');
$router->addRoute('update-intervenant', 'IntervenantController', 'update');

$router->addRoute('intervenant-unsubscribe-request', 'IntervenantController', 'unsubscribeRequest');
$router->addRoute('intervenant-cancel-unsubscribe-request', 'IntervenantController', 'cancelUnsubscribe');

$router->addRoute('picture-edit', 'IntervenantController', 'updatePicture');
$router->addRoute('faq', 'HomeController', 'displayFAQ');
$router->addRoute('oubli', 'HomeController', 'displayForgotten');
$router->addRoute('toggle-mode-intervenant', 'IntervenantController', 'toggleModeIntervenant');
$router->addRoute('emprunter-vehicule', 'IntervenantController', 'emprunterVehicule');

/*
 * Routes avec paramètres
 */
$router->addRoute('my-account&nav=<nav>', 'DemandeurController', 'displayMyAccount');

$router->addRoute('profile&id=<id>', 'IntervenantController', 'profile');

$router->addRoute('success-rdv&date=<date>&horaire=<hours>', 'RendezVousController', 'success');
$router->addRoute('prendre-rdv&intervenant=<id>', 'RendezVousController', 'index');
$router->addRoute('getHoraireNotAvailable&date=<date>&idIntervenant=<id>', 'RendezVousController',
    'getHoraireNotAvailableByIntervenant');
$router->addRoute('delete-rdv&idRdv=<id>', 'RendezVousController', 'deleteRdv');
$router->addRoute('effectue-rdv-inter&idRdv=<id>', 'RendezVousController', 'effectueRdvIntervenant');
$router->addRoute('delete-rdv-inter&idRdv=<id>', 'RendezVousController', 'deleteRdvIntervenant');

$router->addRoute('add-depense', 'NoteFraisController', 'createDepense');
$router->addRoute('edit-depense&idDepense=<id>', 'NoteFraisController', 'updateDepense');
$router->addRoute('delete-depense&idDepense=<id>', 'NoteFraisController', 'deleteDepense');
$router->addRoute('prepare-depenses', 'NoteFraisController', 'prepareDepenses');

$router->addRoute('autocompleteSpecialite&query<query>', 'SpecialiteController', 'autocomplete');
$router->addRoute('autocompleteVille&query=<query>', 'VilleController', 'autocomplete');

$router->addRoute('search&s_name=<name>&s_city=<city>', 'SearchController', 'index');

$router->addRoute('popupAvis&rdvId=<id>', 'RendezVousController', 'ajax');
$router->addRoute('get-depense&idDepense=<id>', 'NoteFraisController', 'ajax');


$requestUrl = $_SERVER['REQUEST_URI'];
$router->handleRequest($requestUrl);