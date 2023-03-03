<?php

namespace App\models\DAO;

use PDO;

class RendezVousDAO extends ConnexionDB
{

    protected static $entity = "RendezVous";


    public static function create($rdv)
    {
        $sql = "INSERT INTO rdv (status, dateRDV, heureDebut, heureFin, idDemandeur, idService, idIntervenant) VALUES (:status, :dateRDV, :heureDebut, :heureFin, :idDemandeur, :idService, :idIntervenant)";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindValue(':status', $rdv->getStatus());
        $stmt->bindValue(':dateRDV', $rdv->getDateRdv());
        $stmt->bindValue(':heureDebut', $rdv->getHeureDebut());
        $stmt->bindValue(':heureFin', $rdv->getHeureFin());
        $stmt->bindValue(':idDemandeur', $rdv->getIdDemandeur());
        $stmt->bindValue(':idService', $rdv->getIdService());
        $stmt->bindValue(':idIntervenant', $rdv->getIdIntervenant());
        $result = $stmt->execute();

        return $result == 1;
    }

    public static function findByIntervenant($idIntervenant)
    {
        $sql = "SELECT * FROM rdv WHERE idIntervenant = :idIntervenant";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindValue(':idIntervenant', $idIntervenant);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::$entity);
        $result = $stmt->fetchAll();

        return $result;
    }

    public static function findHeureNonDispo($idIntervenant, $date)
    {
        $sql = "SELECT heureDebut FROM rdv WHERE idIntervenant = :idIntervenant AND dateRDV = :dateRDV";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindValue(':idIntervenant', $idIntervenant);
        $stmt->bindValue(':dateRDV', $date);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::$entity);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}