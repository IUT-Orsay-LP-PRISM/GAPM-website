<?php

namespace App\models\DAO;

use PDO;

class DemandeurDAO extends ConnexionDB
{

    protected static $entity = "Demandeur";
    protected static $link = 'App\models\entity\\';


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
        $sql = "INSERT INTO demandeur (login, email, motDePasse, nom, prenom, dateNaissance, adresse, telephone, sexe, idVille) VALUES (:login, :email, :motDePasse, :nom, :prenom, :dateNaissance, :adresse, :telephone, :sexe, :idVille)";
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
            'idVille' => $data->getIdVille()
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
        $sql = "UPDATE demandeur SET login = :login, email = :email, motDePasse = :motDePasse, nom = :nom, prenom = :prenom, dateNaissance = :dateNaissance, adresse = :adresse, telephone = :telephone, sexe = :sexe, idVille = :idVille WHERE idDemandeur = :idDemandeur";
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
            'idVille' => $data->getIdVille(),
            'idDemandeur' => $data->getIdDemandeur()
        ]);

        return $result ? $data : false;
    }

}