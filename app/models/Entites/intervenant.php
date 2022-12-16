<?php
class Intervenant extends Demandeur{

// -------------------------------------------------------------------------------------------
// Attributs
	protected $idIntervenant;
	protected $adressePro;

	protected static $objet = "Intervenant";
	protected static $cle = "idIntervenant";


// -------------------------------------------------------------------------------------------
// Constructeur

    function __construct($adressePro) {
        if(!is_null($adressePro)){
            $this->adressePro = $adressePro;
        }
    }


// -------------------------------------------------------------------------------------------
// Getters

    public function getIdIntervenant(){return $this->idIntervenant;}
    public function getAdressePro(){return $this->adressePro;}


// -------------------------------------------------------------------------------------------
// Setters

    //public function setIdIntervenant($idIntervenant){$this->$idIntervenant;}
    public function setAdressePro($adressePro){$this->$adressePro;}
}
?>