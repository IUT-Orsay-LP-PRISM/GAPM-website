<?php
  require_once("modele/NoteFrais.php");

  class ControleurNoteFrais extends ControleurObjet {

    protected static $objet = "NoteFrais";
    protected static $cle = "idNoteFrais";
    protected static $tableauChamp = array(
      "dateNote" => ["date", "Date"],
      "description" => ["text", "Description"],
      "URLJustificatif" => ["url", "URL"],
      "montant" => ["number", "Montant"],
      "status" => ["text", "Status"],
      "login" => ["text", "Login"]
    );

    public static function createNoteFrais(){
      //$titre = "création " . strtolower(static::$objet);

      $result = NoteFrais::insertNoteFrais($_GET['dateNote'],$_GET['description'],$_GET['URLJustificatif'],
      $_GET['montant'], $_GET['status'],$_GET['login']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireCreationObjet();
      }
    }

    public static function modifyNoteFrais(){
      //$titre = "modification " . strtolower(static::$objet);

      $result = NoteFrais::updateNoteFrais($_GET['idNoteFrais'],$_GET['dateNote'],$_GET['description'],
      $_GET['URLJustificatif'], $_GET['montant'], $_GET['status'],$_GET['login']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireModificationObjet();
      }
    }
  }
?>
