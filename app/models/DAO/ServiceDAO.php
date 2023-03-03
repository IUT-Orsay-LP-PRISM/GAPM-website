<?php

namespace App\models\DAO;

use PDO;

class ServiceDAO extends ConnexionDB
{

    protected static $entity = "Service";
    protected static $link = 'App\models\entity\\';


    public static function findByQuery($query)
    {
        $sql = "SELECT * FROM service WHERE libelle LIKE :libelle LIMIT 10";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute([
            'libelle' => "%$query%"
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::$link . static::$entity);
        return $stmt->fetchAll();
    }

    public static function findByIdIntervenant($idIntervenant)
    {
        $sql = "SELECT service.* FROM realiser INNER JOIN service ON realiser.idService = service.idService WHERE idIntervenant = :idIntervenant";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute([
            'idIntervenant' => $idIntervenant
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::$link . static::$entity);
        return $stmt->fetchAll();
    }
}
