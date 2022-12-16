<?php
  require_once("modele/administrateur.php");

  class ControleurAdministrateur extends ControleurObjet {

    protected static $objet = "Administrateur";
    protected static $cle = "idAdministrateur";
    protected static $tableauChamp = array(
      "login" => ["text", "Login"],
      "nom" => ["text", "Nom"],
      "prenom" => ["text", "Prénom"],
      "motDePasse" => ["password", "Mot de passe"]
    );

    public static function createAdministrateur(){
      //$titre = "création " . strtolower(static::$objet);

      $result = Administrateur::insertAdministrateur($_GET['login'],$_GET['nom'],$_GET['prenom'],$_GET['motDePasse']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireCreationObjet();
      }
    }

    public static function modifyAdministrateur(){
      //$titre = "modification " . strtolower(static::$objet);

      $result = Administrateur::updateAdministrateur($_GET['idAdministrateur'],$_GET['login'],$_GET['nom'],$_GET['prenom'],$_GET['motDePasse']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireModificationObjet();
      }
    }
  }
?>
