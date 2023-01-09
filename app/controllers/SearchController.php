<?php

namespace App\controllers;

use App\models\dao\DemandeurDAO;

abstract class SearchController implements InterfaceController
{
    public static function index()
    {
        $nom = $_GET['s_name'];
        $city = $_GET['s_city'];

        $demandeursRecherches = DemandeurDAO::findByNameOrCity($nom, $city);

        require_once "app/views/search.php";
    }

}