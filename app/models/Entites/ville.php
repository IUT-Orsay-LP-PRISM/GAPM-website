<?php

namespace App\models\entity;

class Ville{

// -------------------------------------------------------------------------------------------
// Attributs
	protected $idVille;
	protected $nom;
	protected $codePostal;

	protected static $objet = "Ville";
	protected static $cle = "idVille";


// -------------------------------------------------------------------------------------------
// Constructeur

	function __construct($nom, $codePostal) {
		if(!is_null($nom)){
			$this->nom = $nom;
			$this->codePostal = $codePostal;
		}
	}


// -------------------------------------------------------------------------------------------
// Getters

	public function getIdVille(){return $this->idVille;}
	public function getNom(){return $this->nom;}
	public function getCodePostal(){return $this->codePostal;}


// -------------------------------------------------------------------------------------------
// Setters

	//public function setIdVille($idVille){$this->$idVille;}
	public function setNom($nom){$this->$nom;}
	public function setCodePostal($codePostal){$this->$codePostal;}
}
?>