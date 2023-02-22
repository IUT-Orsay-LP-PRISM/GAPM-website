<?php

namespace App\controllers;

use App\models\dao\VilleDAO;

abstract class VilleController extends Template implements InterfaceController
{
    public static function index()
    {
        self::render('ville/index');
    }

    public static function autocomplete()
    {
        $query = $_GET['query'];
        $villes = VilleDAO::findByQuery($query);
        $villes_json = json_encode(array_map(function ($v) {
            return [
                'id_ville' => $v->getId_Ville(),
                'nom' => $v->getNom(),
                'code_postal' => $v->getCodePostal(),
                'code_departement' => $v->getCodeDepartement()
            ];
        }, $villes));
        echo $villes_json;
    }
}
