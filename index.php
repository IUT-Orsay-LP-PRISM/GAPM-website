<?php

require 'vendor/autoload.php';

use App\controllers\Route;

// Les get de l'url
Route::get('/', 'HomeController', 'index');
Route::get('/?action=demandeur', 'DemandeurController', 'index');
Route::get('/?action=inscription_intervenant', 'InscriptionIntervenenantController', 'index');

// Les post de l'url
Route::get('/?action=loginUser', 'DemandeurController', 'login');

// route::search pour le système de recherche, différent de ::get()
Route::search('/?action=search');
