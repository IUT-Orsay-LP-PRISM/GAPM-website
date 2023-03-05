<?php

namespace App\models\repository;

use Doctrine\ORM\EntityRepository;

class VilleRepository extends EntityRepository
{

    public function findByQuery(string $query)
    {
        $qb = $this->createQueryBuilder('v');
        $qb->where('v.nom LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->orderBy('v.nom', 'ASC')
            ->setMaxResults(10);
        return $qb->getQuery()->getResult();
    }

}