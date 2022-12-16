<?php
class Empechement{

// -------------------------------------------------------------------------------------------
// Attributs
	protected $idEmpechement;
	protected $dateDebut;
	protected $dateFin;
	protected $idIntervenant;

	protected static $objet = "Empechement";
	protected static $cle = "idEmpechement";


// -------------------------------------------------------------------------------------------
// Constructeur

	function __construct($dateDebut, $dateFin, $idIntervenant) {
		if(!is_null($idIntervenant)){
			$this->dateDebut = $dateDebut;
			$this->dateFin = $dateFin;
			$this->idIntervenant = $idIntervenant;
		}
	}


// -------------------------------------------------------------------------------------------
// Getters

	public function getIdEmpechement(){return $this->idEmpechement;}
	public function getDateDebut(){return $this->dateDebut;}
	public function getDateFin(){return $this->dateFin;}
	public function getIdIntervenant(){return $this->idIntervenant;}


// -------------------------------------------------------------------------------------------
// Setters

	//public function setIdEmpechement($idEmpechement){$this->$idEmpechement;}
	public function setDateDebut($dateDebut){$this->$dateDebut;}
	public function setDateFin($dateFin){$this->$dateFin;}
	public function setIdIntervenant($idIntervenant){$this->$idIntervenant;}
}
?>