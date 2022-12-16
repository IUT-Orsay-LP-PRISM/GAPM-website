<?php
  require_once("modele/rendezVous.php");

  class ControleurRendezVous extends ControleurObjet {

    protected static $objet = "rendezVous";
    protected static $cle = "idRendezVous";
    protected static $tableauChamp = array(
      "status" => ["text", "Status"],
      "dateRdv" => ["date", "Date"],
      "heureDebut" => ["time", "Heure début"],
      "heureFin" => ["time", "Heure fin"],
      "idDemandeur" => ["number", "ID Demandeur"],
      "idService" => ["number", "ID Service"],
      "idIntervenant" => ["number", "ID Intervenant"]
    );

    public static function createRendezVous(){
      //$titre = "création " . strtolower(static::$objet);

      $result = RendezVous::insertRendezVous($_GET['status'],$_GET['dateRdv'],$_GET['heureDebut'],
      $_GET['heureFin'], $_GET['idDemandeur'], $_GET['idService'], $_GET['idIntervenant']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireCreationObjet();
      }
    }

    public static function modifyRendezVous(){
      //$titre = "modification " . strtolower(static::$objet);

      $result = RendezVous::updateRendezVous($_GET['idRendezVous'],$_GET['status'],$_GET['dateRdv'],
      $_GET['heureDebut'], $_GET['heureFin'], $_GET['idDemandeur'], $_GET['idService'], $_GET['idIntervenant']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireModificationObjet();
      }
    }
  }
?>
