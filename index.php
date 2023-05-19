<?php

use App\controllers\Router;
use App\models\entity\Session;

require_once 'vendor/autoload.php';
require_once 'bootstrap.php';
require "Router.php";

global $entityManagerFactory;
$entityManager = $entityManagerFactory();

Session::start();

// Exemple d'utilisation
$router = new Router();

// Ajouter des routes
// Routes GET
$router->addRoute('demandeur', 'DemandeurController', 'index');
$router->addRoute('inscription-intervenant', 'IntervenantController', 'index');
$router->addRoute('logout', 'DemandeurController', 'logout');
$router->addRoute('prendre-rdv&intervenant=<id>', 'RendezVousController', 'index');
$router->addRoute('getHoraireNotAvailable&date=<date>&idIntervenant=<id>', 'RendezVousController', 'getHoraireNotAvailableByIntervenant');

$router->addRoute('my-account', 'DemandeurController', 'displayMyAccount');
$router->addRoute('delete-rdv', 'RendezVousController', 'deleteRdv');
$router->addRoute('success-rdv', 'RendezVousController', 'success');
$router->addRoute('mes-rendez-vous', 'RendezVousController', 'displayMyRdv');
$router->addRoute('notes-de-frais', 'NoteFraisController', 'displayNoteFrais');
$router->addRoute('profile', 'IntervenantController', 'profile');

// Routes POST
$router->addRoute('login-user', 'DemandeurController', 'login');
$router->addRoute('register-user', 'DemandeurController', 'register');
$router->addRoute('my-account-edit/', 'DemandeurController', 'update');
$router->addRoute('my-account-delete', 'DemandeurController', 'delete');
$router->addRoute('confirm-RDV', 'RendezVousController', 'createRDV');
$router->addRoute('ajout-avis', 'RendezVousController', 'createNoticeOnRdv');
$router->addRoute('upgrade-to-intervenant', 'IntervenantController', 'devenirIntervenant');
$router->addRoute('update-intervenant', 'IntervenantController', 'update');
$router->addRoute('emprunter-vehicule', 'IntervenantController', 'emprunterVehicule');
$router->addRoute('picture-edit', 'IntervenantController', 'updatePicture');
$router->addRoute('intervenant-unsubscribe-request', 'IntervenantController', 'unsubscribeRequest');
$router->addRoute('intervenant-cancel-unsubscribe-request', 'IntervenantController', 'cancelUnsubscribe');
$router->addRoute('faq', 'HomeController', 'displayFAQ');
$router->addRoute('toggle-mode-intervenant', 'IntervenantController', 'toggleModeIntervenant');

// Route Search
$router->addRoute('search', 'SearchController', 'index');
$router->addRoute('search&s_name=<name>&s_city=<city>', 'SearchController', 'index');

// Route Autocomplete
$router->addRoute('autocompleteSpecialite', 'SpecialiteController', 'autocomplete');
$router->addRoute('autocompleteVille&query=<query>', 'VilleController', 'autocomplete');

// Route Ajax
$router->addRoute('popupAvis', 'RendezVousController', 'ajax');

// Traiter la requête actuelle
$requestUrl = $_SERVER['REQUEST_URI'];
$router->handleRequest($requestUrl);