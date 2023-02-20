<?php

namespace App\models\DAO;

use PDO;

class VilleDAO extends ConnexionDB
{
    protected static $entity = "Ville";
    protected static $link = 'App\models\entity\\';

    public static function findByQuery($query)
    {
        $sql = "SELECT * FROM ville WHERE nom LIKE :nom LIMIT 10";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute([
            'nom' => "%$query%"
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::$link . static::$entity);
        return $stmt->fetchAll();

    }
}
