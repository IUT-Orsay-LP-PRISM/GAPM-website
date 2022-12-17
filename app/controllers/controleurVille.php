<?php
  require_once("modele/Ville.php");

  class ControleurVille extends ControleurObjet {

    protected static $objet = "Ville";
    protected static $cle = "idVille";
    protected static $tableauChamp = array(
      "nom" => ["text", "Nom"],
      "codePostal" => ["text", "CP"]
    );

    public static function createVille(){
      //$titre = "création " . strtolower(static::$objet);

      $result = Ville::insertVille($_GET['nom'],$_GET['codePostal']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireCreationObjet();
      }
    }

    public static function modifyVille(){
      //$titre = "modification " . strtolower(static::$objet);

      $result = Ville::updateVille($_GET['idVille'],$_GET['nom'],$_GET['codePostal']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireModificationObjet();
      }
    }
  }
?>
