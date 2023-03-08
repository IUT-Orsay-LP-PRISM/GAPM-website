<?php

namespace App\models\repository;

use Doctrine\ORM\EntityRepository;

class IntervenantRepository extends EntityRepository
{
    public function findByNameOrCity($nom, $city)
    {
        $qb = $this->createQueryBuilder('i');
        $qb->join('i.ville', 'v')
            ->where($qb->expr()->orX(
                $qb->expr()->like('i.nom', ':nom'),
                $qb->expr()->like('i.prenom', ':nom')
            ))
            ->andWhere($qb->expr()->like('v.nom', ':city'))
            ->setParameter('nom', '%' . $nom . '%')
            ->setParameter('city', '%' . $city . '%')
            ->orderBy('i.nom', 'ASC')
            ->setMaxResults(10);
        return $qb->getQuery()->getResult();
    }
}