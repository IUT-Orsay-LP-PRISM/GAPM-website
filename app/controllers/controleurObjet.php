<?php
class ControleurObjet {

  public static function lireObjets(){
      //$titre = "les " . strtolower(static::$objet) . "s";
      $tableau = static::$objet::getAllObjets();
      $tableauAffichage = array();
      foreach($tableau as $instance) {
      }
      //include("vue/debut.php");
      //include("vue/menu.html");
      //include("vue/lesObjets.php");
      //include("vue/fin.html");
  }

  public static function lireObjet() {
      //$titre = "un " . strtolower(static::$objet);
      $cleValeur = $_GET[static::$cle];
      $objet = (static::$objet)::getObjetById($cleValeur);
      //include("vue/debut.php");
      //include("vue/menu.html");
      //include("vue/unObjet.php");
      //include("vue/fin.html");
  }

  public static function afficherFormulaireCreationObjet() {
    //$titre = "création " . strtolower(static::$objet);
    $tableauChamps = static::$tableauChamp;
    $table = (static::$objet);
    //include("vue/debut.php");
    //include("vue/menu.html");
    //include("vue/formulaireCreationObjet.php");
    //include("vue/fin.html");
  }

  public static function afficherFormulaireModificationObjet() {
    //$titre = "modification " . strtolower(static::$objet);
    $tableauChamps = static::$tableauChamp;
    $table = (static::$objet);
    $cleNom = static::$cle;
    $objetAModifier = $table::getObjetById($_GET[$cleNom]);
    //include("vue/debut.php");
    //include("vue/menu.html");
    //include("vue/formulaireModificationObjet.php");
    //include("vue/fin.html");
  }

  public static function supprimerObjet(){
    $table = static::$objet;
    $cleNom = static::$cle;
    $cleValeur=$_GET[$cleNom];
    $table::deleteObjetById($cleNom);
    //self::lireObjets();
  }
}
?>