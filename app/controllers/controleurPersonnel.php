<?php
  require_once("modele/personnel.php");

  class ControleurPersonnel extends ControleurObjet {

    protected static $objet = "Personnel";
    protected static $cle = "idPersonnel";
    protected static $tableauChamp = array(
      "nom" => ["text", "Nom"],
      "prenom" => ["text", "Prénom"],
      "motDePasse" => ["password", "Mot de passe"],
      "email" => ["email", "email"]
    );

    public static function createPersonnel(){
      //$titre = "création " . strtolower(static::$objet);

      $result = Personnel::insertPersonnel($_GET['nom'],$_GET['prenom'],$_GET['motDePasse'],$_GET['email']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireCreationObjet();
      }
    }

    public static function modifyPersonnel(){
      //$titre = "modification " . strtolower(static::$objet);

      $result = Personnel::updatePersonnel($_GET['idPersonnel'],$_GET['nom'],$_GET['prenom'],$_GET['motDePasse'],$_GET['email']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireModificationObjet();
      }
    }
  }
?>
