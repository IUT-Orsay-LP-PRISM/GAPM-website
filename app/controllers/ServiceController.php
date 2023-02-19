<?php

namespace App\controllers;

use App\models\dao\ServiceDAO;
use App\models\entity\Service;

abstract class ServiceController extends Template implements InterfaceController
{
    public static function index()
    {
        self::render('service/index');
    }

    public static function autocomplete()
    {
        $query = $_GET['query'];
        $services = ServiceDAO::findByQuery($query);
        $services_json = json_encode(array_map(function ($s) {
            return [
                'id_service' => $s->getIdService(),
                'libelle' => $s->getLibelle(),
                'description' => $s->getDescription()
            ];
        }, $services));
        echo $services_json;
    }
}
