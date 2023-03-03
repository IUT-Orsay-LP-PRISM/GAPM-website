<?php

namespace App\controllers;

use App\models\dao\IntervenantDAO;
use App\models\DAO\ServiceDAO;
use App\models\DAO\VilleDAO;

abstract class SearchController extends Template implements InterfaceController
{
    public static function index()
    {
        $nom = $_GET['s_name'] ?? null;
        $city = $_GET['s_city'] ?? null;

        $intervenants = IntervenantDAO::findByNameOrCity($nom, $city);
        foreach ($intervenants as $intervenant) {
            $intervenant->setSpecialites(ServiceDAO::findByIdIntervenant($intervenant->getId_Intervenant()));
        }

        self::render('search.twig', [
            'title' => "Recherche d'un médecin",
            'type' => 'search',
            'city' => $city ,
            'nom' => $nom,
            'intervenants' => $intervenants
        ]);
    }

}