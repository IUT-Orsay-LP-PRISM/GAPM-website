<?php

namespace App\controllers;


use App\models\entity\Demandeur;
use App\models\entity\Specialite;
use App\models\repository\DemandeurRepository;
use App\models\repository\SpecialiteRepository;
use Doctrine\ORM\EntityManager;

class SpecialiteController extends Template
{

    private SpecialiteRepository $specialiteRepository;
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->specialiteRepository = $entityManager->getRepository(Specialite::class);
    }

    public function index()
    {
        self::render('service/index');
    }

    public function autocomplete()
    {
        $query = $_GET['query'];
        $specialites = $this->specialiteRepository->findByQuery($query);

        $specialites_json = json_encode(array_map(function ($s) {
            return [
                'idSpecialite' => $s->getIdSpecialite(),
                'libelle' => $s->getLibelle(),
                'description' => $s->getDescription()
            ];
        }, $specialites));
        echo $specialites_json;
    }
}
