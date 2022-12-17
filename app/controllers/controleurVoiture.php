<?php
  require_once("modele/Voiture.php");

  class ControleurVoiture extends ControleurObjet {

    protected static $objet = "Voiture";
    protected static $cle = "idVoiture";
    protected static $tableauChamp = array(
      "immatriculation" => ["text", "Immatriculation"],
      "idTypeVoiture" => ["number", "ID Type Voiture"]
    );

    public static function createVoiture(){
      //$titre = "création " . strtolower(static::$objet);

      $result = Voiture::insertVoiture($_GET['immatriculation'],$_GET['idTypeVoiture']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireCreationObjet();
      }
    }

    public static function modifyVoiture(){
      //$titre = "modification " . strtolower(static::$objet);

      $result = Voiture::updateVoiture($_GET['idVoiture'],$_GET['immatriculation'],$_GET['idTypeVoiture']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireModificationObjet();
      }
    }
  }
?>
