<?php

namespace App\controllers;

use App\models\dao\IntervenantDAO;
use App\models\DAO\ServiceDAO;
use App\models\DAO\VilleDAO;
use App\models\entity\Intervenant;
use App\models\entity\RendezVous;
use App\models\entity\Specialite;
use App\models\entity\Ville;
use App\models\repository\IntervenantRepository;
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

        $intervenants = $this->entityManager->getRepository(Intervenant::class);
        $specialites = $this->entityManager->getRepository(Specialite::class);


        $intervenants = IntervenantDAO::findByNameOrCity($nom, $city);
        foreach ($intervenants as $intervenant) {
            $intervenant->setSpecialites(ServiceDAO::findByIdIntervenant($intervenant->getIdIntervenant()));
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