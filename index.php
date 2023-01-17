<?php

require 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('app/views');

use App\controllers\Route;

// Les get de l'url
Route::get('/', 'HomeController', 'index');
Route::get('/?action=demandeur', 'DemandeurController', 'index');

// route::search pour le système de recherche, différent de ::get()
Route::search('/?action=search');
