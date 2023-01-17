<?php

namespace App\controllers;

use App\models\dao\DemandeurDAO;
use App\models\entity\Session;

abstract class DemandeurController extends TwigController implements InterfaceController
{
    public static function index()
    {
        $lesDemandeurs = DemandeurDAO::findAll();
        $unDemandeur = DemandeurDAO::findById(5);
        $session = Session::start();

        self::render('demandeurListView.html.twig', [
            'lesDemandeurs' => $lesDemandeurs,
            'unDemandeur' => $unDemandeur,
            'session' => $session
        ]);
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