<?php

namespace App\models\DAO;
use PDO;

class IntervenantDAO extends ConnexionDB
{

    protected static $entity = "Intervenant";
    protected static $link = 'App\models\entity\\';

    public static function create($intervenant)
    {
        $sql = "INSERT INTO intervenant (id_Intervenant, adressePro) VALUES (:id, :adressPro)";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindValue(':id', $intervenant->getId_Intervenant());
        $stmt->bindValue(':adressPro', $intervenant->getAdressePro());
        $result = $stmt->execute();


        $specialites = $intervenant->getSpecialites();
        foreach ($specialites as $service) {
            $sql = "INSERT INTO realiser (id_Intervenant, id_Service) VALUES (:id, :id_Service)";
            $stmt = self::getInstance()->prepare($sql);
            $stmt->bindValue(':id', $intervenant->getId_Intervenant());
            $stmt->bindValue(':id_Service', $service);
            $result = $stmt->execute();
        }

        // ici voiture

        return $result == 1;
    }

    public static function findByNameOrCity($nom, $city)
    {
        $nom = "%$nom%";
        $city = "%$city%";
        $sql = "SELECT demandeur.* FROM demandeur INNER JOIN ville ON demandeur.id_Ville = ville.id_Ville INNER JOIN intervenant ON demandeur.id_Demandeur = intervenant.id_Intervenant WHERE (demandeur.nom LIKE :nom OR demandeur.prenom LIKE :nom) AND ville.nom LIKE :city";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::$link . static::$entity);
        return $stmt->fetchAll();
    }
}
