<?php

namespace App\controllers;

use App\models\dao\DemandeurDAO;
use App\models\entity\Session;

abstract class RendezVousController extends Template implements InterfaceController
{
    public static function prendreRdv()
    {
        if(Session::isLogged() == false) {
            header('Location: /?action=search&s_name=&s_city=&error=Pour prendre rendez-vous, veuillez vous identifier&c=connexion');
            exit;
        }

        $intervenant = DemandeurDAO::findById($_GET['intervenant']);

        self::render('demandeur/search/prendre-rdv.twig', [
            'intervenant' => $intervenant,
            'loader' => false,
            'title' => 'Prendre RDV',
        ]);
    }

}