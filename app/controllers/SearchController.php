<?php

namespace App\controllers;

use App\models\dao\IntervenantDAO;

abstract class SearchController extends Template implements InterfaceController
{
    public static function index()
    {
        $nom = $_GET['s_name'];
        $city = $_GET['s_city'];

        $demandeursRecherches = IntervenantDAO::findByNameOrCity($nom, $city);

        self::render('search.twig', [
            'title' => "Recherche d'un médecin",
            'type' => 'search',
            'city' => $city,
            'nom' => $nom,
            'demandeurs' => $demandeursRecherches
        ]);
    }

}