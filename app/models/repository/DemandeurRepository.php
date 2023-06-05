<?php

namespace App\models\repository;

use Doctrine\ORM\EntityRepository;

class DemandeurRepository extends EntityRepository
{
    public function changeDiscriminatorValue($newValue, $idDemandeur)
    {
        $this->getEntityManager()->getConnection()->executeQuery(
            'UPDATE Demandeur SET type = :newValue WHERE idDemandeur = :id',
            [
                'newValue' => $newValue,
                'id' => $idDemandeur
            ]
        );

        $this->getEntityManager()->getConnection()->executeQuery(
            'INSERT INTO Intervenant (idDemandeur) VALUES (:id)',
            [
                'id' => $idDemandeur
            ]
        );
    }

    public function findByNameLike($query)
    {
        $qb = $this->createQueryBuilder('i');
        $qb->where($qb->expr()->orX(
            $qb->expr()->like('i.nom', ':nom'),
            $qb->expr()->like('i.prenom', ':nom')
        ))
            ->setParameter('nom', '%' . $query . '%')
            ->orderBy('i.nom', 'ASC');
        return $qb->distinct()->getQuery()->getResult();

    }
}