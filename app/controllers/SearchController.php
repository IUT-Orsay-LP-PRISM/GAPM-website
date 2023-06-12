<?php

namespace App\controllers;

use App\models\entity\Intervenant;
use App\models\entity\Session;
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

        $idToDel = null;

        // On récupère la note moyenne de chaque intervenant, s'il en a une
        foreach ($intervenants as $intervenant){
            if (Session::isLogged()){
                if ($intervenant->getIdDemandeur() == Session::get('user')->getIdDemandeur() && Session::get('user')->isIntervenant()){
                    $idToDel = $intervenant->getIdDemandeur();
                }
            }
            $avg = null;
            $note = $intervenantRepository->findNoteById($intervenant->getIdDemandeur());
            if ($note != null) {
                foreach ($note as $n) {
                    $avg += $n['note'];
                }
                $avg = $avg / count($note);
                $avg = round($avg, 1);
                $intervenant->setNoteAvg($avg);
            }
        }

        // Si l'utilisateur est un intervenant, on supprime son profil de la liste & si il est pas en cours d'approbation
        foreach ($intervenants as $key => $intervenant) {
            if ($idToDel != null || $intervenant->isDemandeSupp() || !$intervenant->isTrueIntervenant()) {
                if ($intervenant->getIdDemandeur() == $idToDel || $intervenant->isDemandeSupp() || !$intervenant->isTrueIntervenant()) {
                    unset($intervenants[$key]);
                }
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