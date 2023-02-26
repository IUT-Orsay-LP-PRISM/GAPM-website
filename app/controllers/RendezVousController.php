<?php

namespace App\controllers;

use App\models\dao\DemandeurDAO;
use App\models\dao\IntervenantDAO;
use App\models\dao\ServiceDAO;
use App\models\entity\Session;

abstract class RendezVousController extends Template implements InterfaceController
{
    public static function prendreRdv()
    {
        if(Session::isLogged() == false) {
            header('Location: /?action=search&s_name=&s_city=&error=Pour prendre rendez-vous, veuillez vous identifier&c=connexion');
            exit;
        }

        $demandeur = DemandeurDAO::findById($_GET['demandeur']);
        $intervenant = IntervenantDAO::findById($demandeur->getId_Demandeur());
        if($intervenant == null) {
            header('Location: /?action=search&s_name=&s_city=&error=Intervenant introuvable&c=message');
            exit;
        }
        $services = ServiceDAO::findByIdIntervenant($demandeur->getId_Demandeur());
        $intervenant->setSpecialites($services);

        self::render('demandeur/search/prendre-rdv.twig', [
            'intervenant' => $intervenant,
            'demandeur' => $demandeur,
            'loader' => false,
            'title' => 'Prendre RDV',
        ]);
    }

}