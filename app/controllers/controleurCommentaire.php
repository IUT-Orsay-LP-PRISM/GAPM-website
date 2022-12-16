<?php
  require_once("modele/commentaire.php");

  class ControleurCommentaire extends ControleurObjet {

    protected static $objet = "Commentaire";
    protected static $cle = "idCommentaire";
    protected static $tableauChamp = array(
      "description" => ["text", "Description"],
      "note" => ["number", "Note"],
      "idRdv" => ["number", "ID Rdv"],
      "idDemandeur" => ["number", "ID Demandeur"]
    );

    public static function createCommentaire(){
      //$titre = "création " . strtolower(static::$objet);

      $result = Commentaire::insertCommentaire($_GET['description'],$_GET['note'],$_GET['idRdv'],$_GET['idDemandeur']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireCreationObjet();
      }
    }

    public static function modifyCommentaire(){
      //$titre = "modification " . strtolower(static::$objet);

      $result = Commentaire::updateCommentaire($_GET['idCommentaire'],$_GET['description'],$_GET['note'],$_GET['idRdv'],$_GET['idDemandeur']);

      if($result){
        //self::lireObjets();
      }else{
        //self::afficherFormulaireModificationObjet();
      }
    }
  }
?>
