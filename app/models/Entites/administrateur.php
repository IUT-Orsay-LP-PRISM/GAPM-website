<?php

namespace App\models\entity;

class Administrateur{

// -------------------------------------------------------------------------------------------
// Attributs
	protected $idAdministrateur;
	protected $login;
	protected $nom;
	protected $prenom;
	protected $motDePasse;

	protected static $objet = "Administrateur";
	protected static $cle = "idAdministrateur";


// -------------------------------------------------------------------------------------------
// Constructeur

	function __construct($login, $nom, $prenom, $motDePasse) {
		if(!is_null($login)){
	    	$this->login = $login;
	    	$this->nom = $nom;
	    	$this->prenom = $prenom;
	    	$this->motDePasse = $motDePasse;
		}
	}


// -------------------------------------------------------------------------------------------
// Getters

	public function getIdAdmistrateur(){return $this->idAdministrateur;}
	public function getLogin(){return $this->login;}
	public function getNom(){return $this->nom;}
	public function getPrenom(){return $this->prenom;}
	public function getMotDePasse(){return $this->motDePasse;}


// -------------------------------------------------------------------------------------------
// Setters

	//public function setIdAdministrateur($idAdministrateur){$this->$idAdministrateur;}
	public function setLogin($login){$this->$login;}
	public function setNom($nom){$this->$nom;}
	public function setPrenom($prenom){$this->$prenom;}
	public function setMotDePasse($motDePasse){$this->$motDePasse;}
}
?>