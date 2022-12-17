<?php
  require_once("modele/Empechement.php");

  class ControleurEmpechement extends ControleurObjet {

    protected static $objet = "Empechement";
    protected static $cle = "idEmpechement";
    protected static $tableauChamp = array(
      "dateDebut" => ["date", "Date Debut"],
      "dateFin" => ["date", "Date Fin"],
      "idIntervenant" => ["number", "ID Intervenant"]
    );

    public static function createEmpechement(){
      //$titre = "création " . strtolower(static::$objet);

      $result = Empechement::insertEmpechement($_GET['dateDebut'],$_GET['dateFin'],$_GET['idIntervenant']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireCreationObjet();
      }
    }

    public static function modifyEmpechement(){
      //$titre = "modification " . strtolower(static::$objet);

      $result = Empechement::updateEmpechement($_GET['idEmpechement'],$_GET['dateDebut'],$_GET['dateFin'],$_GET['idIntervenant']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireModificationObjet();
      }
    }
  }
?>
