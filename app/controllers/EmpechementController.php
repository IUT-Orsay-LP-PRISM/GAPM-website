<?php

namespace App\controllers;

use App\models\entity\Empechement;
use App\models\entity\Intervenant;
use App\models\entity\Session;
use App\models\repository\EmpechementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use App\models\entity\CustomMail;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class  EmpechementController extends Template
{
    private EmpechementRepository $empechementRepository;
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->empechementRepository = $entityManager->getRepository(Empechement::class);
    }

    public function create()
    {
        if (!Session::isLogged()) {
            header('Location: /?message=Vous devez être connecté pour accéder à cette page?c=msg-error');
            exit;
        }

        $idIntervenant = Session::get('user')->getIdDemandeur();
        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find($idIntervenant);

        $empechement = new Empechement();
        $empechement->setDateDebut($_POST['dateDebut']);
        $empechement->setDateFin($_POST['dateFin']);
        $empechement->setHeureDebut($_POST['heureDebut']);
        $empechement->setHeureFin($_POST['heureFin']);
        $empechement->setIntervenant($intervenant);

        try {
            $this->entityManager->persist($empechement);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            header('Location: /?action=planning&message=Une erreur est survenue lors de l\'ajout de votre empechement&c=msg-error');
            exit;
        }
        header('Location: /?action=planning&message=Votre empechement a bien été ajouté&c=msg-success');
    }

    public function dislayFormAddEmpechement()
    {
        self::render('intervenant/empechement.twig', [
            'title' => 'Ajouter un empechement',
        ]);
    }

    public function getEmpechementsByIntervenant(): void
    {

        if (!Session::isLogged()) {
            header('Location: /?message=Vous devez être connecté pour accéder à cette page?c=msg-error');
            exit;
        }

        if (!isset($_GET['intervenant'])) {
            header('Location: /?message=Une erreur est survenue lors de la récupération des empechements&c=msg-error');
            exit;
        }


        $idIntervenant = "";
        if(empty($_GET['intervenant']) || $_GET['intervenant'] == "null") {
            $user = Session::get('user');
            $idIntervenant = $user->isIntervenant() ? $user->getIdDemandeur() : $_GET['intervenant'];
        } else {
            $idIntervenant = $_GET['intervenant'];
        }

        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find($idIntervenant);

        $empechements = $this->entityManager->getRepository(Empechement::class)->findByIntervenant($intervenant);
        $dateNow = date('Y-m-d');

        $empechementsDay = [];
        foreach ($empechements as $empechement) {
            if($empechement->getDateFin() >= $dateNow) {
                $empechementsDay[] = [
                    'dateDebut' => $empechement->getDateDebut(),
                    'dateFin' => $empechement->getDateFin(),
                    'heureDebut' => $empechement->getHeureDebut(),
                    'heureFin' => $empechement->getHeureFin()
                ];
            }
        }

        $empechements = [
            'day' => $empechementsDay
        ];

        echo json_encode($empechements);
    }

}
