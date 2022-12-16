<?php
  require_once("modele/FichePaie.php");

  class ControleurFichePaie extends ControleurObjet {

    protected static $objet = "FichePaie";
    protected static $cle = "idFichePaie";
    protected static $tableauChamp = array(
      "url" => ["url", "URL"],
      "idIntervenant" => ["number", "ID Intervenant"],
      "login" => ["text", "Login"]
    );

    public static function createFichePaie(){
      //$titre = "création " . strtolower(static::$objet);

      $result = FichePaie::insertFichePaie($_GET['url'],$_GET['idIntervenant'],$_GET['login']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireCreationObjet();
      }
    }

    public static function modifyFichePaie(){
      //$titre = "modification " . strtolower(static::$objet);

      $result = FichePaie::updateFichePaie($_GET['idFichePaie'],$_GET['url'],$_GET['idIntervenant'],$_GET['login']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireModificationObjet();
      }
    }
  }
?>
