<?php

namespace App\models\Repository;

use Doctrine\ORM\EntityRepository;

class SpecialiteRepository extends EntityRepository
{
    public function findByQuery(string $query)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->where('s.libelle LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->orderBy('s.libelle', 'ASC')
            ->setMaxResults(10);
        return $qb->getQuery()->getResult();
    }
}