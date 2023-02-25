<?php

namespace App\controllers;

use App\models\dao\DemandeurDAO;

abstract class RendezVousController extends Template implements InterfaceController
{
    public static function prendreRdv()
    {
        $intervenant = DemandeurDAO::findById($_GET['intervenant']);

        self::render('demandeur/search/prendre-rdv.twig', [
            'intervenant' => $intervenant,
            'loader' => false,
            'title' => 'Prendre RDV',
        ]);
    }

}