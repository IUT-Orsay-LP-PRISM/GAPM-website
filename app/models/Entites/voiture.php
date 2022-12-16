<?php

namespace App\models\entity;

class Voiture{

// -------------------------------------------------------------------------------------------
// Attributs
	protected $idVoiture;
	protected $immatriculation;
	protected $idTypeVoiture;

	protected static $objet = "Voiture";
	protected static $cle = "idVoiture";


// -------------------------------------------------------------------------------------------
// Constructeur

	function __construct($immatriculation, $idTypeVoiture) {
		if(!is_null($immatriculation)){
			$this->immatriculation = $immatriculation;
			$this->idTypeVoiture = $idTypeVoiture;
		}
	}


// -------------------------------------------------------------------------------------------
// Getters

	public function getIdVoiture(){return $this->idVoiture;}
	public function getImmatriculation(){return $this->immatriculation;}
	public function getIdTypeVoiture(){return $this->idTypeVoiture;}


// -------------------------------------------------------------------------------------------
// Setters

	//public function setIdVoiture($idVoiture){$this->$idVoiture;}
	public function setImmatriculation($immatriculation){$this->$immatriculation;}
	public function setIdTypeVoiture($idTypeVoiture){$this->$idTypeVoiture;}
}
?>