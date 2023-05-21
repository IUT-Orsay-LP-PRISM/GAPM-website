<?php

use App\controllers\Router;
use App\models\entity\Session;

require 'vendor/autoload.php';
require_once 'config/bootstrap.php';

require "Router.php";

global $entityManagerFactory;
$entityManager = $entityManagerFactory();

/*
Route::get('demandeur', 'DemandeurController', 'index');
Route::get('inscription-intervenant', 'IntervenantController', 'index');
Route::get('logout', 'DemandeurController', 'logout');
Route::get('my-account', 'DemandeurController', 'displayMyAccount');
Route::get('prendre-rdv', 'RendezVousController', 'index');
Route::get('delete-rdv', 'RendezVousController', 'deleteRdv');
Route::get('delete-rdv-inter', 'RendezVousController', 'deleteRdvIntervenant');
Route::get('effectue-rdv-inter', 'RendezVousController', 'effectueRdvIntervenant');

Route::get('success-rdv', 'RendezVousController', 'success');
Route::get('mes-rendez-vous', 'RendezVousController', 'displayMyRdv');
Route::get('liste-rdv', 'RendezVousController', 'displayMyRdvIntervenant');
Route::get('notes-de-frais', 'NoteFraisController', 'displayNoteFrais');
Route::get('delete-depense', 'NoteFraisController', 'deleteDepense');

Route::post('login-user', 'DemandeurController', 'login');
Route::post('register-user', 'DemandeurController', 'register');
Route::post('my-account-edit/', 'DemandeurController', 'update');
Route::post('my-account-delete', 'DemandeurController', 'delete');
Route::post('confirm-RDV', 'RendezVousController', 'createRDV');
Route::post('ajout-avis', 'RendezVousController', 'createNoticeOnRdv');
Route::post('upgrade-to-intervenant', 'IntervenantController', 'devenirIntervenant');
Route::post('update-intervenant', 'IntervenantController', 'update');
Route::post('emprunter-vehicule', 'IntervenantController', 'emprunterVehicule');
Route::post('picture-edit', 'IntervenantController', 'updatePicture');
Route::post('add-depense', 'NoteFraisController', 'createDepense');
Route::post('edit-depense', 'NoteFraisController', 'updateDepense');
Route::post('prepare-depenses', 'NoteFraisController', 'prepareDepenses');


Route::post('intervenant-unsubscribe-request', 'IntervenantController', 'unsubscribeRequest');
Route::post('intervenant-cancel-unsubscribe-request', 'IntervenantController', 'cancelUnsubscribe');

Route::get('profile', 'IntervenantController', 'profile');

Route::post('faq', 'HomeController', 'displayFAQ');

// route::pour le système de toggle du mode intervenant
Route::post('toggle-mode-intervenant', 'IntervenantController', 'toggleModeIntervenant');


// route::search pour le système de recherche, différent de ::get()
Route::search('/?action=search');

// route::search pour le système de autocomplete, différent de ::get()
Route::autocomplete('/?action=autocompleteSpecialite','Specialite');
Route::autocomplete('/?action=autocompleteVille','Ville');
Route::ajax('/?action=popupAvis','RendezVous');
Route::ajax('/?action=get-depense','NoteFrais');
=======
Session::start();
*/

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