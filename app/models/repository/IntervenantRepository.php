<?php

namespace App\models\repository;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityRepository;

class IntervenantRepository extends EntityRepository
{

    /**
     * @throws Exception
     */
    public function findNoteById($id){
        return $this->getEntityManager()->getConnection()->executeQuery(
            "SELECT idIntervenant, R.idDemandeur, note, description  FROM Commentaire 
            INNER JOIN RDV R on Commentaire.idCommentaire = R.idCommentaire 
            WHERE idIntervenant = :id",
            [
                'id' => $id
            ]
        )->fetchAllAssociative();
    }

    public function findByNameOrCity($nom, $city)
    {
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