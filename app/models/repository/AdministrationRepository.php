<?php

namespace App\models\repository;

use Doctrine\ORM\EntityRepository;

class AdministrationRepository extends EntityRepository
{

    public function findNbRdvBySpecialite()
    {
        $results = $this->getEntityManager()->getConnection()->executeQuery(
            "SELECT specialite.libelle, COUNT(rdv.idRdv) AS nbRdv
        FROM specialite
        INNER JOIN rdv ON specialite.idSpecialite = rdv.idSpecialite
        GROUP BY rdv.idSpecialite;"
        )->fetchAllAssociative();

        $resultArray = [];
        foreach ($results as $result) {
            $libelle = $result['libelle'];
            $nb = $result['nbRdv'];
            $resultArray[$libelle] = $nb;
        }

        return $resultArray;
    }


    public function findNbRdvByDay()
    {
        $results = $this->getEntityManager()->getConnection()->executeQuery(
            "SELECT 
            CASE 
                WHEN DAYNAME(dateRDV) = 'Monday' THEN 'Lundi'
                WHEN DAYNAME(dateRDV) = 'Tuesday' THEN 'Mardi'
                WHEN DAYNAME(dateRDV) = 'Wednesday' THEN 'Mercredi'
                WHEN DAYNAME(dateRDV) = 'Thursday' THEN 'Jeudi'
                WHEN DAYNAME(dateRDV) = 'Friday' THEN 'Vendredi'
                WHEN DAYNAME(dateRDV) = 'Saturday' THEN 'Samedi'
                WHEN DAYNAME(dateRDV) = 'Sunday' THEN 'Dimanche'
            END AS jourSemaine,
            COUNT(*) AS nbRendezVous
        FROM RDV
        GROUP BY jourSemaine;"
        )->fetchAllAssociative();

        $resultArray = [];
        foreach ($results as $result) {
            $jour = $result['jourSemaine'];
            $nb = $result['nbRendezVous'];
            $resultArray[$jour] = $nb;
        }
        return $resultArray;
    }

    public function findNbRdvByTrancheHorraire()
    {
        $results = $this->getEntityManager()->getConnection()->executeQuery(
            "SELECT
                    CONCAT(
                        heureDebut,
                        ' - ',
                        heureFin
                    ) AS tranche_horaire,
                    COUNT(*) AS nombre_rdv
                FROM
                    RDV
                GROUP BY tranche_horaire;"
        )->fetchAllAssociative();

        $resultArray = [];
        foreach ($results as $result) {
            $tranche = $result['tranche_horaire'];
            $nb = $result['nombre_rdv'];
            $resultArray[$tranche] = $nb;
        }
        return $resultArray;
    }

    public function findTauxByStatusRdv() {
        $results = $this->getEntityManager()->getConnection()->executeQuery(
            "SELECT
                    status,
                    (COUNT(*) / (SELECT COUNT(*) FROM RDV) * 100) AS taux
                FROM
                    RDV
                GROUP BY
                    status;"
        )->fetchAllAssociative();

        $resultArray = [];
        foreach ($results as $result) {
            $status = $result['status'];
            $taux = $result['taux'];
            $resultArray[$status] = $taux;
        }

        return $resultArray;
    }

    public function findTauxSatisfaction() {
        $results = $this->getEntityManager()->getConnection()->executeQuery(
            "SELECT
                    AVG(note) AS taux_satisfaction
                FROM
                    Commentaire;"
        )->fetchAllAssociative();


        return $results[0];
    }

    public function findNbCommentaireByRdvEffectue() {
        $results = $this->getEntityManager()->getConnection()->executeQuery(
            "SELECT
                    COUNT(DISTINCT idCommentaire) AS nombre_commentaires,
                    COUNT(*) AS nombre_rdv_effectues
                FROM
                    RDV
                WHERE
                    status = 'effectue';"
        )->fetchAllAssociative();

        $resultArray = [];
        foreach ($results as $result) {
            $nbCommentaire = $result['nombre_commentaires'];
            $nbRdvEffectue = $result['nombre_rdv_effectues'];
            $resultArray['nbCommentaire'] = $nbCommentaire;
            $resultArray['nbRdvEffectue'] = $nbRdvEffectue;
        }

        return $resultArray;
    }
}