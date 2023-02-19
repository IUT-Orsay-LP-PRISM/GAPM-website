<?php

namespace App\models\DAO;

use App\models\entity\Demandeur;
use PDO;

class DemandeurDAO extends ConnexionDB{

    protected static $entity = "Demandeur";
    protected static $link = 'App\models\entity\\';

    public static function findByNameOrCity($nom, $city)
    {
        $sql = "SELECT * FROM demandeur WHERE nom LIKE :nom AND prenom LIKE :city";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute([
            'nom' => "%$nom%",
            'city' => "%$city%"
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::$link . static::$entity);
        return $stmt->fetchAll();
    }
    public static function checkIfEmailExists($email){
        $sql = "SELECT login FROM demandeur WHERE email = :email";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute([
            'email' => "$email"
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::$link . static::$entity);
        $result = $stmt->fetchAll();
        if($result != null){
            return true;
        }
        else{
            return false;
        }
        
    }

    public static function getPasswordFromEmail($email){
        $sql = "SELECT motDePasse FROM demandeur WHERE email = :email ";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute([
            'email' => "$email"
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::$link . static::$entity);
        return $stmt->fetch();
    }
}
