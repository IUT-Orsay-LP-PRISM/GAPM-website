<?php

namespace App\models\DAO;
use PDO;

class IntervenantDAO extends ConnexionDB
{

    protected static $entity = "Intervenant";
    protected static $link = 'App\models\entity\\';

    public static function create($intervenant)
    {
        $sql = "INSERT INTO intervenant (idIntervenant, adressePro) VALUES (:id, :adressPro)";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindValue(':id', $intervenant->getIdIntervenant());
        $stmt->bindValue(':adressPro', $intervenant->getAdressePro());
        $result = $stmt->execute();


        $specialites = $intervenant->getSpecialites();
        foreach ($specialites as $service) {
            $sql = "INSERT INTO Intervenant_Specialite (idIntervenant, idService) VALUES (:id, :idService)";
            $stmt = self::getInstance()->prepare($sql);
            $stmt->bindValue(':id', $intervenant->getIdIntervenant());
            $stmt->bindValue(':idService', $service);
            $result = $stmt->execute();
        }

        // ici voiture

        return $result == 1;
    }

    public static function findByNameOrCity($nom, $city)
    {
        $nom = "%$nom%";
        $city = "%$city%";
        $sql = "SELECT demandeur.*, intervenant.idIntervenant FROM demandeur INNER JOIN ville ON demandeur.idVille = ville.idVille INNER JOIN intervenant ON demandeur.idDemandeur = intervenant.idIntervenant WHERE (demandeur.nom LIKE :nom OR demandeur.prenom LIKE :nom) AND ville.nom LIKE :city";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::$link . static::$entity);
        return $stmt->fetchAll();
    }
}
