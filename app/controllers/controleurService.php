<?php
  require_once("modele/service.php");

  class ControleurService extends ControleurObjet {

    protected static $objet = "Service";
    protected static $cle = "idService";
    protected static $tableauChamp = array(
      "description" => ["text", "Description"]
    );

    public static function createService(){
      //$titre = "création " . strtolower(static::$objet);

      $result = Service::insertService($_GET['description']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireCreationObjet();
      }
    }

    public static function modifyService(){
      //$titre = "modification " . strtolower(static::$objet);

      $result = Service::updateService($_GET['idService'],$_GET['description']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireModificationObjet();
      }
    }
  }
?>
