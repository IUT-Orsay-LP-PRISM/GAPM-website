<?php
  require_once("modele/Intervenant.php");

  class ControleurIntervenant extends ControleurObjet {

    protected static $objet = "Intervenant";
    protected static $cle = "idIntervenant";
    protected static $tableauChamp = array(
      "adressePro" => ["text", "Adresse Pro"],
      "idDemandeur" => ["number", "ID Demandeur"]
    );

    public static function createIntervenant(){
      //$titre = "création " . strtolower(static::$objet);

      $result = Intervenant::insertIntervenant($_GET['login'],$_GET['motDePasse'],$_GET['nom'],$_GET['prenom']
      $_GET['dateNaissance'],$_GET['adresse'],$_GET['telephone'],$_GET['sexe'],$_GET['idVille'],$_GET['adressePro']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireCreationObjet();
      }
    }

    public static function modifyIntervenant(){
      //$titre = "modification " . strtolower(static::$objet);

      $result = Intervenant::updateIntervenant($_GET['idIntervenant'],$_GET['login'],$_GET['motDePasse'],$_GET['nom'],
      $_GET['prenom'],$_GET['dateNaissance'],$_GET['adresse'],$_GET['telephone'],$_GET['sexe'],$_GET['idVille'],
      $_GET['adressePro']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireModificationObjet();
      }
    }
  }
?>
