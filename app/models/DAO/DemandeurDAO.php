<?php

namespace App\models\DAO;

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
            $idDemandeur = self::getInstance()->lastInsertId();
            $data->setIdDemandeur($idDemandeur);
            return $data;
        }
        return false;
    }

    public  static function update($data)
    {
        $sql = "UPDATE demandeur SET login = :login, email = :email, motDePasse = :motDePasse, nom = :nom, prenom = :prenom, dateNaissance = :dateNaissance, adresse = :adresse, telephone = :telephone, sexe = :sexe, id_Ville = :id_Ville WHERE id_Demandeur = :idDemandeur";
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
            'id_Ville' => $data->getId_Ville(),
            'idDemandeur' => $data->getIdDemandeur()
        ]);

        return $result ? $data : false;
    }

}