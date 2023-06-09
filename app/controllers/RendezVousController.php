<?php

namespace App\controllers;

use App\models\entity\Commentaire;
use App\models\entity\CustomMail;
use App\models\entity\Demandeur;
use App\models\entity\Empechement;
use App\models\entity\Intervenant;
use App\models\entity\RendezVous;
use App\models\entity\Session;
use App\models\entity\Specialite;
use App\models\repository\RendezVousRepository;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class RendezVousController extends Template
{
    private RendezVousRepository $rendezVousRepository;
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->rendezVousRepository = $entityManager->getRepository(RendezVous::class);
    }

    public function index(): void
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

    public function deleteRdv(): void
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

        $demandeur = $this->entityManager->getRepository(Demandeur::class)->find($idDemandeur);
        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find($rdv->getIntervenant());

        $referer = $_SERVER['HTTP_REFERER'];
        $referer_parts = parse_url($referer);
        $referer = $referer_parts['scheme'] . '://' . $referer_parts['host'] . '/?action=mes-rendez-vous';

        $phpmailer = new CustomMail();
        $phpmailer->sendCancelRdv("le demandeur", $demandeur, $intervenant, $rdv, $referer);

        //send the message, check for errors
        if (!$phpmailer->send()) {
            echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
        } else {
            header('Location: /?action=mes-rendez-vous&message=Votre rendez-vous a bien été annulé&c=msg-success');
        }
        exit;
    }

    public function deleteRdvIntervenant(): void
    {
        if (!Session::isLogged()) {
            header('Location: /?action=search&message=Pour prendre rendez-vous, veuillez vous identifier&c=connexion');
            exit;
        }

        if (!Session::get('user')->isIntervenant()) {
            header('Location: /?action=mes-rendez-vous&message=Vous n\'êtes pas un intervenant&c=msg-error');
            exit;
        }

        $idRdv = htmlspecialchars($_GET['idRdv']);
        $idIntervenant = Session::get('user')->getIdDemandeur();
        $rdv = $this->entityManager->getRepository(RendezVous::class)->findOneBy(['idRdv' => $idRdv, 'intervenant' => $idIntervenant]);
        if ($rdv == null) {
            header('Location: /?action=liste-rdv&message=Ce rendez-vous n\'existe pas !&c=msg-error');
            exit;
        }
        try {
            $rdv->setStatus('annule');
            $this->entityManager->persist($rdv);
            $this->entityManager->flush();

            $demandeur = $this->entityManager->getRepository(Demandeur::class)->find($rdv->getDemandeur());
            $intervenant = $this->entityManager->getRepository(Intervenant::class)->find($rdv->getIntervenant());

            $referer = $_SERVER['HTTP_REFERER'];
            $referer_parts = parse_url($referer);
            $referer = $referer_parts['scheme'] . '://' . $referer_parts['host'] . '/?action=mes-rendez-vous';

            $phpmailer = new CustomMail();
            $phpmailer->sendCancelRdv("l'intervenant", $demandeur, $intervenant, $rdv, $referer);

            //send the message, check for errors
            if (!$phpmailer->send()) {
                echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
            } else {
                header('Location: /?action=liste-rdv&message=Le rendez-vous a bien été annulé&c=msg-success');
            }
            exit;
        } catch (ORMException $e) {
            header('Location: /?action=liste-rdv&message=Une erreur est survenue lors de l\'annulation du rendez-vous&c=msg-error');
            exit;
        }
    }

    public function effectueRdvIntervenant(): void
    {
        if (!Session::isLogged()) {
            header('Location: /?action=search&message=Pour prendre rendez-vous, veuillez vous identifier&c=connexion');
            exit;
        }

        if (!Session::get('user')->isIntervenant()) {
            header('Location: /?action=mes-rendez-vous&message=Vous n\'êtes pas un intervenant&c=msg-error');
            exit;
        }

        $idRdv = htmlspecialchars($_GET['idRdv']);
        $idIntervenant = Session::get('user')->getIdDemandeur();
        $rdv = $this->entityManager->getRepository(RendezVous::class)->findOneBy(['idRdv' => $idRdv, 'intervenant' => $idIntervenant]);
        if ($rdv == null) {
            header('Location: /?action=liste-rdv&message=Ce rendez-vous n\'existe pas !&c=msg-error');
            exit;
        }
        try {
            $rdv->setStatus('effectue');
            $this->entityManager->persist($rdv);
            $this->entityManager->flush();
            header('Location: /?action=liste-rdv&message=Le rendez-vous a bien été effectué !&c=msg-success');
            exit;

        } catch (ORMException $e) {
            header('Location: /?action=liste-rdv&message=Une erreur est survenue lors de la validation du rendez-vous&c=msg-error');
            exit;
        }
    }

    public function createRDV(): void
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
            header('Location: /?action=search&message=Une erreur est survenue lors de la création du rendez-vous&c=message');
            exit;
        }

        $referer = $_SERVER['HTTP_REFERER'];
        $referer_parts = parse_url($referer);
        $referer = $referer_parts['scheme'] . '://' . $referer_parts['host'] . '/?action=mes-rendez-vous';

        $phpmailer = new CustomMail();
        $phpmailer->sendRdv($demandeur, $intervenant, $rdv, $referer);

        //send the message, check for errors
        if (!$phpmailer->send()) {
            echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
        } else {
            header('Location: /?action=success-rdv&date=' . $date . '&horaire=' . $horaireDebut);
        }
    }

    public function success(): void
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

    public function getHoraireNotAvailableByIntervenant(): void
    {
        $date = $_GET['date'];
        $idIntervenant = $_GET['idIntervenant'];
        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find($idIntervenant);
        $horaire = $this->rendezVousRepository->findHeureNonDispo($intervenant, $date);

        $empechements = $this->entityManager->getRepository(Empechement::class)->findByIntervenant($intervenant);
        $dateNow = date('Y-m-d');
        $empechementsTime = [];
        foreach ($empechements as $empechement) {
            if($empechement->getDateFin() >= $dateNow && ($empechement->getHeureDebut() !== "00:00:00" || $empechement->getHeureFin() !== "00:00:00")) {
                $empechementsTime[] = [
                    'dateDebut' => $empechement->getDateDebut(),
                    'dateFin' => $empechement->getDateFin(),
                    'heureDebut' => $empechement->getHeureDebut(),
                    'heureFin' => $empechement->getHeureFin()
                ];
            }
        }

        $trancheMinutes = 30;
        $trancheHours = array();
        foreach ($empechementsTime as $empechement) {
            $empechementHeureDebut = $empechement['heureDebut'];
            $empechementHeureFin = $empechement['heureFin'];

            $heureDebut = new DateTime($empechementHeureDebut);
            $heureFin = new DateTime($empechementHeureFin);

            while ($heureDebut < $heureFin) {
                $heureCourante = $heureDebut->format('H:i');

                // Vérifier si l'heure courante est entre 8h et 19h
                if ($heureCourante >= '08:00' && $heureCourante <= '19:00') {
                    $horaire[] = array('heureDebut' => $heureCourante);
                }

                $heureDebut->add(new DateInterval("PT{$trancheMinutes}M"));
            }
        }

        echo json_encode($horaire);
    }

    public function displayMyRdv(): void
    {
        if (!Session::isLogged()) {
            header('Location: /?action=search&message=Pour voir vos rendez vous, connectez vous!&c=connexion');
            exit;
        }

        $user = Session::get('user');
        $demandeur = $this->entityManager->getRepository(Demandeur::class)->find($user->getIdDemandeur());
        $mesRdv = $demandeur->getRendezVous();
        usort($mesRdv, function ($a, $b) {
            return $a->getDateRdv() <=> $b->getDateRdv();
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
            if (!$rdv->getCommentaire()->isNull()) {
                if ($rdv->getStatus() == strtolower('Effectue')) {
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

    public function displayMyRdvIntervenant(): void
    {
        if (!Session::isLogged()) {
            header('Location: /?action=search&message=Pour voir vos rendez vous, connectez vous!&c=connexion');
            exit;
        }
        if (!Session::get('user')->isIntervenant()) {
            header('Location: /?action=search&message=Vous n\'êtes pas un intervenant!&c=connexion');
            exit;
        }

        $user = Session::get('user');
        $intervenant = $this->entityManager->getRepository(Demandeur::class)->find($user->getIdDemandeur());
        $rdvIntervenant = $intervenant->getMesRendezVous();

        $mesRdvAjd = [];
        $mesRdvAVenir = [];
        $allRdvsAfter = [];
        $mesRdvFilter = [];
        if (!empty($_GET['date'])) {
            foreach ($rdvIntervenant as $rdv) {
                if ($rdv->getDateRdv() == $_GET['date']) {
                    $mesRdvFilter[] = $rdv;
                }
            }
        }

        foreach ($rdvIntervenant as $rdv) {
            if ($rdv->getDateRdv() == date('Y-m-d') && $rdv->getStatus() == 'confirme') {
                $mesRdvAjd[] = $rdv;
            } elseif ($rdv->getDateRdv() > date('Y-m-d') && $rdv->getStatus() == 'confirme') {
                $rdv->setDateRdv(date('d/m', strtotime($rdv->getDateRdv())));
                $mesRdvAVenir[] = $rdv;
            } elseif ($rdv->getStatus() == 'effectue' || $rdv->getStatus() == 'annule') {
                $rdv->setDateRdv(date('d/m', strtotime($rdv->getDateRdv())));
                if ($rdv->getStatus() == 'effectue') {
                    $rdv->setStatus('Effectué');
                } else {
                    $rdv->setStatus('Annulé');
                }
                $allRdvsAfter[] = $rdv;
            }
        }

        usort($mesRdvAVenir, function ($a, $b) {
            return $a->getDateRdv() <=> $b->getDateRdv();
        });

        $mesRdv = [
            'today' => $mesRdvAjd,
            'next' => $mesRdvAVenir,
            'all' => $allRdvsAfter,
            'filter' => [
                'date' => $_GET['date'] ?? null,
                'rdv' => $mesRdvFilter,
            ],
        ];

        self::render('intervenant/mes-rdv.twig', [
            'title' => 'Mes rendez-vous',
            'user' => $intervenant,
            'mesRdv' => $mesRdv,
        ]);
    }


    public function createNoticeOnRdv(): void
    {
        if (!Session::isLogged()) {
            header('Location: /?action=search&message=Pour laisser un avis, connectez vous!&c=connexion');
            exit;
        }

        $user = Session::get('user');

        $idRdv = intval($_POST['idRdv']);
        $commentaire = $_POST['commentaire'];
        $note = $_POST['note'];
        $rdv = $this->entityManager->getRepository(RendezVous::class)->find($idRdv);
        $demandeur = $this->entityManager->getRepository(Demandeur::class)->find($user->getIdDemandeur());
        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find($rdv->getIntervenant());

        $com = new Commentaire();
        /** @var Demandeur $demandeur */
        $com->setDemandeur($demandeur);
        $com->setDescription($commentaire);
        $com->setNote($note);
        /** @var RendezVous $rdv */
        $com->setRendezVous($rdv);

        $rdv->setCommentaire($com);

        try {
            $this->entityManager->persist($com);
            $this->entityManager->persist($rdv);
            $this->entityManager->flush();

            $referer = $_SERVER['HTTP_REFERER'];
            $referer_parts = parse_url($referer);
            $referer = $referer_parts['scheme'] . '://' . $referer_parts['host'] . '/?action=mes-rendez-vous';


            $phpmailer = new CustomMail();
            $phpmailer->sendCommentaire($demandeur, $intervenant, $rdv, $referer);

            //send the message, check for errors
            if (!$phpmailer->send()) {
                echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
            } else {
                header('Location: /?action=mes-rendez-vous&message=Votre avis a bien été enregistré&c=msg-success');
            }
        } catch (ORMException $e) {
            header('Location: /?action=mes-rendez-vous&message=Une erreur est survenue lors de l\'enregistrement de votre avis&c=msg-error');
            exit;
        }
    }

    public function ajax(): void
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