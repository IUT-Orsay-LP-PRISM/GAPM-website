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


        $ordre = array(
            "Lundi" => 1,
            "Mardi" => 2,
            "Mercredi" => 3,
            "Jeudi" => 4,
            "Vendredi" => 5,
            "Samedi" => 6,
            "Dimanche" => 7
        );
        // sort $NbRdvByDay by day
        uksort($NbRdvByDay, function ($a, $b) use ($ordre) {
            return $ordre[$a] - $ordre[$b];
        });

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