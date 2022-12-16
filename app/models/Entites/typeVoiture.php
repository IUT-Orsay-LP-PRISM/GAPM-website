<?php
class TypeVoiture{

// -------------------------------------------------------------------------------------------
// Attributs
	protected $idTypeVoiture;
	protected $modele;

	protected static $objet = "TypeVoiture";
	protected static $cle = "idTypeVoiture";


// -------------------------------------------------------------------------------------------
// Constructeur

	function __construct($modele) {
		if(!is_null($modele)){
			$this->modele = $modele;
		}
	}


// -------------------------------------------------------------------------------------------
// Getters

	public function getIdTypeVoiture(){return $this->idTypeVoiture;}
	public function getModele(){return $this->modele;}


// -------------------------------------------------------------------------------------------
// Setters

	//public function setIdTypeVoiture($idTypeVoiture){$this->$idTypeVoiture;}
	public function setModele($modele){$this->$modele;}
}
?>