<?php

namespace App\models\repository;

use Doctrine\ORM\EntityRepository;

class DemandeurRepository extends EntityRepository
{

    public function checkEmail($email)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT d.email FROM Demandeur d WHERE d.email = :email'
        )->setParameter('email', $email);

        $result = $query->getResult();
        if (empty($result)) {
            return false;
        } else {
            return true;
        }
    }

}