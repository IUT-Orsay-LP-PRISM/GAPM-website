<?php

namespace App\models\entity;

class FichePaie{

// -------------------------------------------------------------------------------------------
// Attributs
	protected $idFichePaie;
	protected $url;
	protected $idIntervenant;
	protected $login;

	protected static $objet = "FichePaie";
	protected static $cle = "idFichePaie";


// -------------------------------------------------------------------------------------------
// Constructeur

	function __construct($url, $idIntervenant, $login) {
		if(!is_null($idIntervenant)){
			$this->url = $url;
			$this->idIntervenant = $idIntervenant;
			$this->login = $login;
		}
	}


// -------------------------------------------------------------------------------------------
// Getters

	public function getIdFichePaie(){return $this->idFichePaie;}
	public function getUrl(){return $this->url;}
	public function getIdIntervenant(){return $this->idIntervenant;}
	public function getLogin(){return $this->login;}


// -------------------------------------------------------------------------------------------
// Setters

	//public function setIdFichePaie($idFichePaie){$this->$idFichePaie;}
	public function setUrl($url){$this->$url;}
	public function setIdIntervenant($idIntervenant){$this->$idIntervenant;}
	public function setLogin($login){$this->$login;}
}
?>