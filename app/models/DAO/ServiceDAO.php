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
        $sql = "SELECT service.* FROM realiser INNER JOIN service ON realiser.id_Service = service.id_Service WHERE id_intervenant = :id_intervenant";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute([
            'id_intervenant' => $idIntervenant
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::$link . static::$entity);
        return $stmt->fetchAll();
    }
}
