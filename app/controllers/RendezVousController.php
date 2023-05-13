<?php

namespace App\controllers;

use App\models\entity\Commentaire;
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
            header('Location: /?action=search&message=Pour prendre rendez-vous, veuillez vous identifier&c=connexion');
            exit;
        }
        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find($_GET['intervenant']);
        if ($intervenant == null) {
            header('Location: /?action=search&message=Intervenant introuvable&c=message');
            exit;
        }

        self::render('demandeur/search/prendre-rdv.twig', [
            'intervenant' => $intervenant,
            'title' => 'Prendre RDV'
        ]);
    }

    public function deleteRdv()
    {
        if (!Session::isLogged()) {
            header('Location: /?action=search&message=Pour prendre rendez-vous, veuillez vous identifier&c=connexion');
            exit;
        }

        $idRdv = $_GET['idRdv'];
        $idDemandeur = Session::get('user')->getIdDemandeur();
        $rdv = $this->entityManager->getRepository(RendezVous::class)->findOneBy(['idRdv' => $idRdv, 'demandeur' => $idDemandeur]);
        if ($rdv == null) {
            header('Location: /?action=mes-rendez-vous&message=Ce rendez-vous n\'existe pas !&c=msg-error');
            exit;
        }
        $rdv->setStatus('annule');
        $this->entityManager->persist($rdv);
        $this->entityManager->flush();

        header('Location: /?action=mes-rendez-vous&message=Votre rendez-vous a bien été annulé&c=msg-success');
        exit;
    }
    public function createRDV()
    {
        if (Session::isLogged() == false) {
            header('Location: /?action=search&message=Pour prendre rendez-vous, veuillez vous identifier&c=connexion');
            exit;
        }

        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find($_POST['idIntervenant']);

        if ($intervenant == null) {
            header('Location: /?action=search&message=Intervenant introuvable&c=message');
            exit;
        }
        $horaireDebut = $_POST['horaire'];
        $horaireFin = date('H:i', strtotime($horaireDebut) + 1800);
        $date = $_POST['date'];
        $status = 'confirme';
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
            header('Location: /?action=search&message=Une erreur est survenue lors de la création du rendez-vous&c=message');
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
            header('Location: /?action=search&message=Pour voir vos rendez vous, connectez vous!&c=connexion');
            exit;
        }

        $user = Session::get('user');
        $demandeur = $this->entityManager->getRepository(Demandeur::class)->find($user->getIdDemandeur());
        $mesRdv = $demandeur->getRendezVous();
        usort($mesRdv, function ($a, $b) {
            return $b->getDateRdv() <=> $a->getDateRdv();
        });

        $avisALaisser = [];
        $mesRdvConfirme = [];
        $mesRdvAnnule = [];
        $mesRdvEffectue = [];
        foreach ($mesRdv as $rdv) {
            switch ($rdv->getStatus()) {
                case strtolower('Confirme'):
                    $mesRdvConfirme[] = $rdv;
                    break;
                case strtolower('Effectue'):
                    $mesRdvEffectue[] = $rdv;
                    break;
                case strtolower('Annule'):
                    $mesRdvAnnule[] = $rdv;
                    break;
            }
            if (!$rdv->getCommentaire()->isNull()){
                if($rdv->getStatus() == strtolower('Effectue')){
                    $avisALaisser[] = $rdv;
                }
            }

        }

        $mesRdv = [
            'confirme' => $mesRdvConfirme,
            'effectue' => $mesRdvEffectue,
            'annule' => $mesRdvAnnule,
            'avisALaisser' => $avisALaisser,
        ];

        self::render('demandeur/mes-rdv.twig', [
            'title' => 'Mes rendez-vous',
            'user' => $demandeur,
            'mesRdv' => $mesRdv
        ]);
    }

    public function createNoticeOnRdv()
    {
        if (!Session::isLogged()) {
            header('Location: /?action=search&message=Pour laisser un avis, connectez vous!&c=connexion');
            exit;
        }

        $user = Session::get('user');

        $idRdv = intval($_POST['idRdv']);
        $commentaire = $_POST['commentaire'];
        $note = $_POST['note'];
        $demandeur = $this->entityManager->getRepository(Demandeur::class)->find($user->getIdDemandeur());
        $rdv = $this->entityManager->getRepository(RendezVous::class)->find($idRdv);

        $com = new Commentaire();
        $com->setDemandeur($demandeur);
        $com->setDescription($commentaire);
        $com->setNote($note);
        $com->setRendezVous($rdv);

        $rdv->setCommentaire($com);

        $this->entityManager->persist($com);
        $this->entityManager->persist($rdv);
        $this->entityManager->flush();

        header('Location: /?action=mes-rendez-vous&message=Votre avis a bien été enregistré&c=msg-success');
    }

    public function ajax()
    {
        $query = $_GET['rdvId'];

        $rdv = $this->entityManager->getRepository(RendezVous::class)->find($query);

        $rdv_json = [
            'id' => $rdv->getIdRdv(),
            'date' => $rdv->getDateRdv(),
            'heureDebut' => $rdv->getHeureDebut(),
            'heureFin' => $rdv->getHeureFin(),
            'specialite' => $rdv->getSpecialite()->getLibelle(),
            'intervenant' => $rdv->getIntervenant()->getNom() . ' ' . $rdv->getIntervenant()->getPrenom(),
        ];
        echo json_encode($rdv_json);
    }
}