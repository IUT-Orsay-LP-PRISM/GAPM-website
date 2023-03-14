<?php

namespace App\controllers;

use App\models\entity\Demandeur;
use App\models\entity\Intervenant;
use App\models\entity\RendezVous;
use App\models\entity\Session;
use App\models\entity\Specialite;
use App\models\repository\RendezVousRepository;
use Doctrine\ORM\EntityManager;

class RendezVousController extends Template
{
    private RendezVousRepository $rendezVousRepository;
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->rendezVousRepository = $entityManager->getRepository(RendezVous::class);
    }

    public function index()
    {
        if (!Session::isLogged()) {
            header('Location: /?action=search&error=Pour prendre rendez-vous, veuillez vous identifier&c=connexion');
            exit;
        }
        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find($_GET['intervenant']);
        if ($intervenant == null) {
            header('Location: /?action=search&error=Intervenant introuvable&c=message');
            exit;
        }

        self::render('demandeur/search/prendre-rdv.twig', [
            'intervenant' => $intervenant,
            'title' => 'Prendre RDV'
        ]);
    }

    public function createRDV()
    {
        if (Session::isLogged() == false) {
            header('Location: /?action=search&error=Pour prendre rendez-vous, veuillez vous identifier&c=connexion');
            exit;
        }

        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find($_POST['idIntervenant']);

        if ($intervenant == null) {
            header('Location: /?action=search&error=Intervenant introuvable&c=message');
            exit;
        }
        $horaireDebut = $_POST['horaire'];
        $horaireFin = date('H:i', strtotime($horaireDebut) + 1800);
        $date = $_POST['date'];
        $status = 'En attente';
        $idUser = Session::get('user')->getIdDemandeur();
        $idSpecialite = $_POST['specialite'];

        $demandeur = $this->entityManager->getRepository(Demandeur::class)->find($idUser);
        $specialite = $this->entityManager->getRepository(Specialite::class)->find($idSpecialite);
        // TODO : Vérifier que l'intervenant est disponible à cette date et à cette heure

        $rdv = new RendezVous();
        $rdv->setStatus($status);
        $rdv->setDateRdv($date);
        $rdv->setHeureDebut($horaireDebut);
        $rdv->setHeureFin($horaireFin);
        $rdv->setDemandeur($demandeur);
        $rdv->setSpecialite($specialite);
        $rdv->setIntervenant($intervenant);

        try {
            $this->entityManager->persist($rdv);
            $this->entityManager->flush();
            $result = true;
        } catch (\Exception $e) {
            dump($e);
            die();
            header('Location: /?action=search&error=Une erreur est survenue lors de la création du rendez-vous&c=message');
            exit;
        }
        header('Location: /?action=success-rdv&date=' . $date . '&horaire=' . $horaireDebut);
    }

    public function success()
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

    public function getHoraireNotAvailableByIntervenant()
    {
        $date = $_GET['date'];
        $idIntervenant = $_GET['idIntervenant'];
        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find($idIntervenant);
        $horaire = $this->rendezVousRepository->findHeureNonDispo($intervenant, $date);
        echo json_encode($horaire);
    }

    public function displayMyRdv()
    {
        if (!Session::isLogged()) {
            header('Location: /?action=search&error=Pour voir vos rendez vous, connectez vous!&c=connexion');
            exit;
        }

        $user = Session::get('user');
        $demandeur = $this->entityManager->getRepository(Demandeur::class)->find($user->getIdDemandeur());
        $mesRdv = $demandeur->getRendezVous();

        $mesRdvConfirme = [];
        $mesRdvEnAttente = [];
        $mesRdvAnnule = [];
        $mesRdvEffectue = [];
        foreach ($mesRdv as $rdv) {
            switch ($rdv->getStatus()) {
                case 'En attente':
                    $mesRdvEnAttente[] = $rdv;
                    break;
                case 'Confirme':
                    $mesRdvConfirme[] = $rdv;
                    break;
                case 'Effectue':
                    $mesRdvEffectue[] = $rdv;
                    break;
                case 'Annule':
                    $mesRdvAnnule[] = $rdv;
                    break;
            }
        }

        $mesRdv = [
            'confirme' => $mesRdvConfirme,
            'attente' => $mesRdvEnAttente,
            'effectue' => $mesRdvEffectue,
            'annule' => $mesRdvAnnule
        ];

        self::render('demandeur/mes-rdv.twig', [
            'title' => 'Mes rendez-vous',
            'user' => $demandeur,
            'mesRdv' => $mesRdv
        ]);
    }
}