<?php

namespace App\models\dao;

use PDO;

class DemandeurDAO extends ConnexionDB
{

    public static function getAllDemandeur()
    {
        $query = "Select * from demandeur";
        $rq = self::getInstance()->query($query);
        $rq->setFetchMode(PDO::FETCH_CLASS, 'App\models\entity\Demandeur');
        return $rq->fetchAll();
    }


}