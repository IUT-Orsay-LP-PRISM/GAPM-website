<?php

namespace App\controllers;

use App\models\dao\DemandeurDAO;
use App\models\dao\IntervenantDAO;
use App\models\dao\ServiceDAO;
use App\models\dao\VilleDAO;
use App\models\dao\RendezVousDAO;
use App\models\entity\RendezVous;
use App\models\entity\Session;

abstract class RendezVousController extends Template implements InterfaceController
{
    public static function index()
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

         $ville = VilleDAO::findById($demandeur->getId_Ville());

        self::render('demandeur/search/prendre-rdv.twig', [
            'intervenant' => $intervenant,
            'demandeur' => $demandeur,
            'loader' => false,
            'ville' => $ville,
            'title' => 'Prendre RDV'
        ]);
    }

    public static function createRDV() {
        if(Session::isLogged() == false) {
            header('Location: /?action=search&s_name=&s_city=&error=Pour prendre rendez-vous, veuillez vous identifier&c=connexion');
            exit;
        }

        $demandeur = DemandeurDAO::findById($_POST['idIntervenant']);
        $intervenant = IntervenantDAO::findById($demandeur->getId_Demandeur());
        if($intervenant == null) {
            header('Location: /?action=search&s_name=&s_city=&error=Intervenant introuvable&c=message');
            exit;
        }
        $services = ServiceDAO::findByIdIntervenant($demandeur->getId_Demandeur());
        $intervenant->setSpecialites($services);

        $horaireDebut = $_POST['horaire'];
        $horaireFin = date('H:i', strtotime($horaireDebut) + 1800);
        $date = $_POST['date'];
        $idIntervenant = $intervenant->getId_Intervenant();
        $idDemandeur = Session::get('user')->getId_Demandeur();
        $status = 'En attente';
        $services = ServiceDAO::findByIdIntervenant($idIntervenant);
        $service = $services[0];

        // TODO : Vérifier que l'intervenant est disponible à cette date et à cette heure
        // TODO : Ajouter le choix du service

        $rdv = new RendezVous();
        $rdv->setStatus($status);
        $rdv->setDateRdv($date);
        $rdv->setHeureDebut($horaireDebut);
        $rdv->setHeureFin($horaireFin);
        $rdv->setId_Demandeur($idDemandeur);
        $rdv->setId_Service($service->getIdService());
        $rdv->setId_Intervenant($idIntervenant);
        RendezVousDAO::create($rdv);

        if($rdv == null) {
            header('Location: /?action=search&s_name=&s_city=&error=Une erreur est survenue lors de la création du rendez-vous&c=message');
            exit;
        }
        header('Location: /?action=search&s_name=&s_city=&success=Votre rendez-vous a bien été créé&c=message');
        exit;
    }
}