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
        if (Session::isLogged() == false) {
            header('Location: /?action=search&error=Pour prendre rendez-vous, veuillez vous identifier&c=connexion');
            exit;
        }

        $demandeur = DemandeurDAO::findById($_GET['demandeur']);
        $intervenant = IntervenantDAO::findById($demandeur->getId_Demandeur());
        if ($intervenant == null) {
            header('Location: /?action=search&error=Intervenant introuvable&c=message');
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

    public static function createRDV()
    {
        if (Session::isLogged() == false) {
            header('Location: /?action=search&error=Pour prendre rendez-vous, veuillez vous identifier&c=connexion');
            exit;
        }

        $demandeur = DemandeurDAO::findById($_POST['idIntervenant']);
        $intervenant = IntervenantDAO::findById($demandeur->getId_Demandeur());
        if ($intervenant == null) {
            header('Location: /?action=search&error=Intervenant introuvable&c=message');
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
        $idService = $_POST['specialite'];

        // TODO : Vérifier que l'intervenant est disponible à cette date et à cette heure

        $rdv = new RendezVous();
        $rdv->setStatus($status);
        $rdv->setDateRdv($date);
        $rdv->setHeureDebut($horaireDebut);
        $rdv->setHeureFin($horaireFin);
        $rdv->setId_Demandeur($idDemandeur);
        $rdv->setId_Service($idService);
        $rdv->setId_Intervenant($idIntervenant);
        $result = RendezVousDAO::create($rdv);

        if ($rdv == null) {
            header('Location: /?action=search&error=Une erreur est survenue lors de la création du rendez-vous&c=message');
            exit;
        }

        if($result == false) {
            header('Location: /?action=search&error=Une erreur est survenue lors de la création du rendez-vous&c=message');
            exit;
        } else {
            header('Location: /?action=success-rdv&date=' . $date . '&horaire=' . $horaireDebut);
            exit;
        }
    }

    public static function success()
    {

        $date = $_GET['date'];
        $horaire = $_GET['horaire'];
        $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $mois = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        $dateString = $jours[date('w', strtotime($date))] . ' ' . date('d', strtotime($date)) . ' ' . $mois[date('n', strtotime($date))] . ' ' . date('Y', strtotime($date));

        self::render('demandeur/search/success-rdv.twig', [
            'loader' => false,
            'title' => 'Prendre RDV',
            'date' => $dateString,
            'horaire' => $_GET['horaire'] ?? null,
        ]);
    }
}