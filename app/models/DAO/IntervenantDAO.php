<?php

namespace App\models\DAO;
use PDO;

class IntervenantDAO extends ConnexionDB
{

    protected static $entity = "Intervenant";

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
}
