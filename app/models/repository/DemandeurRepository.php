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
}