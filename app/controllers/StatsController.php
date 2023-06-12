<?php

namespace App\controllers;

use App\models\entity\Administration;
use Doctrine\ORM\EntityManager;

class StatsController extends Template
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function ajax()
    {
        $NbRdvBySpecialite = $this->entityManager->getRepository(Administration::class)->findNbRdvBySpecialite();

        $NbRdvByDay = $this->entityManager->getRepository(Administration::class)->findNbRdvByDay();

        $NbRdvByTrancheHorraire = $this->entityManager->getRepository(Administration::class)->findNbRdvByTrancheHorraire();

        $TauxStatusRdv = $this->entityManager->getRepository(Administration::class)->findTauxByStatusRdv();

        $TauxSatisfaction = $this->entityManager->getRepository(Administration::class)->findTauxSatisfaction();

        $nbCommentaireByRdvEffectue = $this->entityManager->getRepository(Administration::class)->findNbCommentaireByRdvEffectue();


        // Création du tableau associatif contenant les résultats
        $data = array(
            'NbRdvBySpecialite' => $NbRdvBySpecialite,
            'NbRdvByDay' => $NbRdvByDay,
            'NbRdvByTrancheHorraire' => $NbRdvByTrancheHorraire,
            'TauxStatusRdv' => $TauxStatusRdv,
            'TauxSatisfaction' => $TauxSatisfaction,
            'nbCommentaireByRdvEffectue' => $nbCommentaireByRdvEffectue
        );

        // Conversion en JSON
        $jsonData = json_encode($data);

        // Retourner le JSON
        echo $jsonData;
    }
}