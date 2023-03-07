<?php
use App\controllers\Route;
use App\models\entity\Session;
require 'vendor/autoload.php';
require_once 'bootstrap.php';

Session::start();

global $entityManagerFactory;
$entityManager = $entityManagerFactory();

Route::get('demandeur', 'DemandeurController', 'index');
Route::get('inscription-intervenant', 'IntervenantController', 'index');
Route::get('logout', 'DemandeurController', 'logout');
Route::get('my-account', 'DemandeurController', 'displayMyAccount');
Route::get('prendre-rdv', 'RendezVousController', 'index');
Route::get('success-rdv', 'RendezVousController', 'success');

Route::post('login-user', 'DemandeurController', 'login');
Route::post('register-user', 'DemandeurController', 'register');
Route::post('my-account-edit', 'DemandeurController', 'update');
Route::post('my-account-delete', 'DemandeurController', 'delete');
Route::post('confirm-RDV', 'RendezVousController', 'createRDV');

// route::search pour le système de recherche, différent de ::get()
Route::search('/?action=search');

// route::search pour le système de autocomplete, différent de ::get()
Route::autocomplete('/?action=autocompleteService','Service');
Route::autocomplete('/?action=autocompleteVille','Ville');

// route::Ajax pour retiré les date deja use d'un rdv
Route::get("getHoraireNotAvailable", "RendezVousController", "getHoraireNotAvailableByIntervenant");
