<?php

namespace App\controllers;

use App\models\entity\Depense;
use App\models\entity\NoteFrais;
use App\models\entity\Session;
use App\models\repository\NoteFraisRepository;
use Doctrine\ORM\EntityManager;

class NoteFraisController extends Template
{
    private NoteFraisRepository $noteFraisRepository;
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->noteFraisRepository = $entityManager->getRepository(NoteFrais::class);
    }

    public function displayNoteFrais()
    {
        if (!Session::isLogged()) {
            header('Location: /?action=search&message=Pour voir vos notes de frais, veuillez vous identifier&c=connexion');
            exit;
        }
        $depenses = $this->entityManager->getRepository(Depense::class)->findBy(['intervenant' => Session::get('user')->getIdDemandeur()]);


        self::render('demandeur/notes-de-frais.twig', [
            'title' => 'Notes de frais',
            'depenses' => $depenses
        ]);

    }
}