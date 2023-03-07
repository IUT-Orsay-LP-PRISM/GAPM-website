<?php

namespace App\models\repository;

use Doctrine\ORM\EntityRepository;

class RendezVousRepository extends EntityRepository
{
    public function findHeureNonDispo($intervenant, $date)
    {
        $qb = $this->createQueryBuilder('r');
        $qb->select('r.heureDebut')
        ->where($qb->expr()->eq('r.intervenant', ':intervenant'))
            ->andWhere($qb->expr()->eq('r.dateRdv', ':date'))
            ->setParameter('intervenant', $intervenant)
            ->setParameter('date', $date);
        return $qb->getQuery()->getResult();
    }
}