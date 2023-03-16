<?php

namespace App\models\repository;

use Doctrine\ORM\EntityRepository;

class IntervenantRepository extends EntityRepository
{
    public function findByNameOrCity($nom, $city)
    {
        /* $newnom = '%'.$nom.'%';
        $newcity = '%'.$city.'%';
        $results = $this->getEntityManager()->getConnection()->executeQuery(
            "SELECT * FROM Demandeur as i join ville as v on i.idVille = v.idVille 
            WHERE i.nom LIKE ':nom'  AND v.nom LIKE ':city' 
            OR i.prenom LIKE ':nom'  AND v.nom LIKE ':city'
            OR i.idDemandeur IN (
                SELECT idIntervenant FROM intervenant_specialite AS interspe 
                JOIN specialite AS s on interspe.idSpecialite = s.idSpecialite  
                WHERE s.libelle LIKE ':nom'  OR s.description LIKE ':nom'
            ) AND v.nom LIKE ':city'
            ORDER BY i.nom ASC",
            [
                'nom' => $newnom,
                'city' => $newcity
            ]
        )->fetchAllAssociative();

        return $results; */
         
        /* $rsm = new ResultSetMapping();
        $likenom = '%'.$nom.'%';
        $likecity = '%'.$city.'%';
        $results = $this->getEntityManager()->createNativeQuery(
            "SELECT * FROM Demandeur as i join ville as v on i.idVille = v.idVille 
            WHERE i.nom LIKE('?1') AND v.nom LIKE('?2')
            OR i.prenom LIKE('?3') AND v.nom LIKE('?4')
            OR i.idDemandeur IN (
                SELECT idIntervenant FROM intervenant_specialite AS interspe 
                JOIN specialite AS s on interspe.idSpecialite = s.idSpecialite  
                WHERE s.libelle LIKE('?5') OR s.description LIKE('?6')
            ) AND v.nom LIKE('?7')
            ORDER BY i.nom ASC",$rsm);
        $parameters = array(
            '1' => $likenom, 
            '2' => $likecity,
            '3' => $likenom, 
            '4' => $likecity,
            '5' => $likenom, 
            '6' => $likenom,
            '7' => $likecity
        );
        $results->setParameters($parameters);

        return $results->getResult(); */

        $qb = $this->createQueryBuilder('i');
        $qb->join('i.villePro', 'v')
            ->where($qb->expr()->orX(
                $qb->expr()->like('i.nom', ':nom'),
                $qb->expr()->like('i.prenom', ':nom')
            ))
            ->andWhere($qb->expr()->like('v.nom', ':city'))
            ->setParameter('nom', '%' . $nom . '%')
            ->setParameter('city', '%' . $city . '%')
            ->orderBy('i.nom', 'ASC')
            ->setMaxResults(10);
        return $qb->distinct()->getQuery()->getResult();
    }
}