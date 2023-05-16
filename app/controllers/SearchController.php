<?php

namespace App\controllers;

use App\models\entity\Intervenant;
use Doctrine\ORM\EntityManager;

class SearchController extends Template
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function index()
    {
        $nom = $_GET['s_name'] ?? null;
        $city = $_GET['s_city'] ?? null;

        $intervenantRepository = $this->entityManager->getRepository(Intervenant::class);
        $intervenants = $intervenantRepository->findByNameOrCity($nom, $city);

        $avg = null;
        foreach ($intervenants as $intervenant){
            $note = $intervenantRepository->findNoteById($intervenant->getIdDemandeur());
            if ($note != null){
                foreach ($note as $n) {
                    $avg += $n['note'];
                }
                $avg = $avg / count($note);
                $avg = round($avg, 1);
                $intervenant->setNoteAvg($avg);
            }
        }

        self::render('search.twig', [
            'title' => "Recherche d'un médecin",
            'type' => 'search',
            'city' => $city ,
            'nom' => $nom,
            'intervenants' => $intervenants
        ]);
    }

}