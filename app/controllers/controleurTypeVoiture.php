<?php
  require_once("modele/TypeVoiture.php");

  class ControleurTypeVoiture extends ControleurObjet {

    protected static $objet = "TypeVoiture";
    protected static $cle = "idTypeVoiture";
    protected static $tableauChamp = array(
      "modele" => ["text", "Modèle"]
    );

    public static function createTypeVoiture(){
      //$titre = "création " . strtolower(static::$objet);

      $result = TypeVoiture::insertTypeVoiture($_GET['modele']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireCreationObjet();
      }
    }

    public static function modifyTypeVoiture(){
      //$titre = "modification " . strtolower(static::$objet);

      $result = TypeVoiture::updateTypeVoiture($_GET['idTypeVoiture'],$_GET['modele']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireModificationObjet();
      }
    }
  }
?>
