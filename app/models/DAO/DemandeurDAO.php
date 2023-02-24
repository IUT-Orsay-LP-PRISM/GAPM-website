<?php

namespace App\models\DAO;

use App\models\entity\Demandeur;
use PDO;

class DemandeurDAO extends ConnexionDB
{

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

    public static function checkIfEmailExists($email)
    {
        $sql = "SELECT login FROM demandeur WHERE email = :email";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute([
            'email' => "$email"
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::$link . static::$entity);
        $result = $stmt->fetchAll();
        return !($result == null);
    }

    public static function getUserFromEmail($email)
    {
        $sql = "SELECT *  FROM demandeur WHERE email = :email ";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute([
            'email' => "$email"
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::$link . static::$entity);
        return $stmt->fetch();
    }

    public static function create($data)
    {
        $sql = "INSERT INTO demandeur (login, email, motDePasse, nom, prenom, dateNaissance, adresse, telephone, sexe, id_Ville) VALUES (:login, :email, :motDePasse, :nom, :prenom, :dateNaissance, :adresse, :telephone, :sexe, :id_Ville)";
        $stmt = self::getInstance()->prepare($sql);
        $result = $stmt->execute([
            'login' => $data->getNom() . "." . $data->getPrenom(),
            'email' => $data->getEmail(),
            'motDePasse' => $data->getMotDePasse(),
            'nom' => $data->getNom(),
            'prenom' => $data->getPrenom(),
            'dateNaissance' => $data->getDateNaissance(),
            'adresse' => $data->getAdresse(),
            'telephone' => $data->getTelephone(),
            'sexe' => $data->getSexe(),
            'id_Ville' => $data->getId_Ville()
        ]);

        if ($result) {
            return self::getInstance()->lastInsertId();
        }
        return false;

    }
}