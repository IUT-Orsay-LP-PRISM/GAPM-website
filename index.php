<?php

require 'vendor/autoload.php';
\App\models\entity\Session::start();

use App\controllers\Route;

// Les get de l'url
// Basé sur /?action=...
Route::get('demandeur', 'DemandeurController', 'index');
Route::get('inscription-intervenant', 'IntervenantController', 'index');
Route::get('logout', 'DemandeurController', 'logout');
Route::get('my-account', 'DemandeurController', 'myAccount');

// Les post de l'url
Route::post('login-user', 'DemandeurController', 'login');
Route::post('register-user', 'DemandeurController', 'register');
Route::post('my-account-edit', 'DemandeurController', 'update');
Route::get('my-account-delete', 'DemandeurController', 'delete');



// route::search pour le système de recherche, différent de ::get()
Route::search('/?action=search');

// route::search pour le système de autocomplete, différent de ::get()
Route::autocomplete('/?action=autocompleteService','Service');
Route::autocomplete('/?action=autocompleteVille','Ville');
