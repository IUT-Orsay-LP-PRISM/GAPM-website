<?php
  require_once("modele/Emprunt.php");

  class ControleurEmprunt extends ControleurObjet {

    protected static $objet = "Emprunt";
    protected static $cle = "idEmprunt";
    protected static $tableauChamp = array(
      "dateDebut" => ["date", "Date Debut"],
      "dateFin" => ["date", "Date Fin"],
      "idIntervenant" => ["number", "ID Intervenant"],
      "login" => ["text", "Login"],
      "idVoiture" => ["number", "ID Voiture"],
    );

    public static function createEmprunt(){
      //$titre = "création " . strtolower(static::$objet);

      $result = Emprunt::insertEmprunt($_GET['dateDebut'],$_GET['dateFin'],$_GET['idIntervenant'],$_GET['login'],$_GET['idVoiture']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireCreationObjet();
      }
    }

    public static function modifyEmprunt(){
      //$titre = "modification " . strtolower(static::$objet);

      $result = Emprunt::updateEmprunt($_GET['idEmprunt'],$_GET['dateDebut'],$_GET['dateFin'],$_GET['idIntervenant'],$_GET['login'],$_GET['idVoiture']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireModificationObjet();
      }
    }
  }
?>
