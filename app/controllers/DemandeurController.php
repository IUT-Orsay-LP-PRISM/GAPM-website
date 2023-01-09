<?php

namespace App\controllers;

use App\models\dao\DemandeurDAO;

abstract class DemandeurController implements InterfaceController
{
    public static function index()
    {
        $lesDemandeurs = DemandeurDAO::findAll();
        $unDemandeur = DemandeurDAO::findById(1);
        require_once "app/views/demandeurListView.php";
    }

    public static function store()
    {


    }

    public static function update()
    {
        // TODO: Implement update() method.
    }

    public static function delete()
    {
        // TODO: Implement delete() method.
    }

    public static function show()
    {
        // TODO: Implement show() method.
    }
}