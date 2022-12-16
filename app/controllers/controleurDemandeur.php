<?php
  require_once("modele/demandeur.php");

  class ControleurDemandeur extends ControleurObjet {

    protected static $objet = "Demandeur";
    protected static $cle = "idDemandeur";
    protected static $tableauChamp = array(
      "login" => ["text", "Login"],
      "motDePasse" => ["password", "Mot de passe"],
      "nom" => ["text", "Nom"],
      "prenom" => ["text", "Prénom"],
      "dateNaissance" => ["date", "Date de naissance"],
      "adresse" => ["text", "Adresse"],
      "telephone" => ["text", "Téléphone"],
      "sexe" => ["text", "Sexe"],
      "idVille" => ["number", "ID Ville"]
    );

    public static function createDemandeur(){
      //$titre = "création " . strtolower(static::$objet);

      $result = Demandeur::insertDemandeur($_GET['login'],$_GET['motDePasse'],$_GET['nom'],$_GET['prenom']
      $_GET['dateNaissance'],$_GET['adresse'],$_GET['telephone'],$_GET['sexe'],$_GET['idVille']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireCreationObjet();
      }
    }

    public static function modifyDemandeur(){
      //$titre = "modification " . strtolower(static::$objet);

      $result = Demandeur::updateDemandeur($_GET['idDemandeur'],$_GET['login'],$_GET['motDePasse'],$_GET['nom'],
      $_GET['prenom'],$_GET['dateNaissance'],$_GET['adresse'],$_GET['telephone'],$_GET['sexe'],$_GET['idVille']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireModificationObjet();
      }
    }
  }
?>
