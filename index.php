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
$router->addRoute('/\?action=demandeur', 'DemandeurController', 'index');
$router->addRoute('/\?action=inscription-intervenant', 'IntervenantController', 'index');
$router->addRoute('/\?action=logout', 'DemandeurController', 'logout');
$router->addRoute('/\?action=prendre-rdv&intervenant={intervenant}', 'RendezVousController', 'index');
$router->addRoute('/\?action=getHoraireNotAvailable&date={date}&idIntervenant={idIntervenant}', 'RendezVousController', 'getHoraireNotAvailableByIntervenant');

$router->addRoute('/\?action=my-account', 'DemandeurController', 'displayMyAccount');
$router->addRoute('/\?action=delete-rdv', 'RendezVousController', 'deleteRdv');
$router->addRoute('/\?action=success-rdv', 'RendezVousController', 'success');
$router->addRoute('/\?action=mes-rendez-vous', 'RendezVousController', 'displayMyRdv');
$router->addRoute('/\?action=notes-de-frais', 'NoteFraisController', 'displayNoteFrais');
$router->addRoute('/\?action=profile', 'IntervenantController', 'profile');

// Routes POST
$router->addRoute('/\?action=login-user', 'DemandeurController', 'login');
$router->addRoute('/\?action=register-user', 'DemandeurController', 'register');
$router->addRoute('/\?action=my-account-edit/', 'DemandeurController', 'update');
$router->addRoute('/\?action=my-account-delete', 'DemandeurController', 'delete');
$router->addRoute('/\?action=confirm-RDV', 'RendezVousController', 'createRDV');
$router->addRoute('/\?action=ajout-avis', 'RendezVousController', 'createNoticeOnRdv');
$router->addRoute('/\?action=upgrade-to-intervenant', 'IntervenantController', 'devenirIntervenant');
$router->addRoute('/\?action=update-intervenant', 'IntervenantController', 'update');
$router->addRoute('/\?action=emprunter-vehicule', 'IntervenantController', 'emprunterVehicule');
$router->addRoute('/\?action=picture-edit', 'IntervenantController', 'updatePicture');
$router->addRoute('/\?action=intervenant-unsubscribe-request', 'IntervenantController', 'unsubscribeRequest');
$router->addRoute('/\?action=intervenant-cancel-unsubscribe-request', 'IntervenantController', 'cancelUnsubscribe');
$router->addRoute('/\?action=faq', 'HomeController', 'displayFAQ');
$router->addRoute('/\?action=toggle-mode-intervenant', 'IntervenantController', 'toggleModeIntervenant');

// Route Search
$router->addRoute('/\?action=search&s_name={name}&s_city={lol}', 'SearchController', 'index');

// Route Autocomplete
$router->addRoute('/\?action=autocompleteSpecialite', 'SpecialiteController', 'autocomplete');
$router->addRoute('/\?action=autocompleteVille', 'VilleController', 'autocomplete');

// Route Ajax
$router->addRoute('/\?action=popupAvis', 'RendezVousController', 'ajax');

// Traiter la requête actuelle
$requestUrl = $_SERVER['REQUEST_URI'];
$router->handleRequest($requestUrl);