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
            ->andWhere($qb->expr()->neq('r.status', ':status'))
            ->setParameter('intervenant', $intervenant)
            ->setParameter('date', $date)
            ->setParameter('status', 'annule');
        return $qb->getQuery()->getResult();
    }

}