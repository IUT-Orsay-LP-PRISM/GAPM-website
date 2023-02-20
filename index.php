<?php

require 'vendor/autoload.php';

use App\controllers\Route;

// Les get de l'url
// Basé sur /?action=...
Route::get('/', 'HomeController', 'index');
Route::get('demandeur', 'DemandeurController', 'index');
Route::get('inscription_intervenant', 'IntervenantController', 'index');

// Les post de l'url
Route::get('loginUser', 'DemandeurController', 'login');

// route::search pour le système de recherche, différent de ::get()
Route::search('/?action=search');

// route::search pour le système de autocomplete, différent de ::get()
Route::autocomplete('/?action=autocomplete','Service');

Route::notFound();