<?php

namespace App\models\DAO;

use PDO;

class RendezVousDAO extends ConnexionDB
{

    protected static $entity = "RendezVous";


    public static function create($rdv)
    {
        $sql = "INSERT INTO rdv (status, dateRDV, heureDebut, heureFin, id_demandeur, id_Service, id_Intervenant) VALUES (:status, :dateRDV, :heureDebut, :heureFin, :id_demandeur, :id_Service, :id_Intervenant)";
        $stmt = self::getInstance()->prepare($sql);
        $stmt->bindValue(':status', $rdv->getStatus());
        $stmt->bindValue(':dateRDV', $rdv->getDateRdv());
        $stmt->bindValue(':heureDebut', $rdv->getHeureDebut());
        $stmt->bindValue(':heureFin', $rdv->getHeureFin());
        $stmt->bindValue(':id_demandeur', $rdv->getId_Demandeur());
        $stmt->bindValue(':id_Service', $rdv->getId_Service());
        $stmt->bindValue(':id_Intervenant', $rdv->getId_Intervenant());
        $result = $stmt->execute();

        return $result == 1;
    }
}