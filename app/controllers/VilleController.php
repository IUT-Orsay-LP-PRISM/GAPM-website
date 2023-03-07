<?php

namespace App\controllers;

use App\models\entity\Demandeur;
use App\models\entity\Ville;
use App\models\repository\DemandeurRepository;
use App\models\repository\VilleRepository;
use Doctrine\ORM\EntityManager;

class VilleController extends Template
{
    private VilleRepository $villeRepository;
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->villeRepository = $entityManager->getRepository(Ville::class);
    }
    public function autocomplete()
    {
        $query = $_GET['query'];

        $villes = $this->villeRepository->findByQuery($query);

        $villes_json = json_encode(array_map(function ($v) {
            return [
                'idVille' => $v->getIdVille(),
                'nom' => $v->getNom(),
                'code_postal' => $v->getCodePostal()
            ];
        }, $villes));
        echo $villes_json;
    }
}
