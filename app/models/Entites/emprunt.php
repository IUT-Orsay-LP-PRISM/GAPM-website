<?php
class Emprunt{

// -------------------------------------------------------------------------------------------
// Attributs
	protected $idEmprunt;
	protected $dateDebut;
	protected $dateFin;
	protected $idIntervenant;
	protected $login;
	protected $idVoiture;

	protected static $objet = "Emprunt";
	protected static $cle = "idEmprunt";


// -------------------------------------------------------------------------------------------
// Constructeur

	function __construct($dateDebut, $dateFin, $idIntervenant, $login, $idVoiture) {
		if(!is_null($idIntervenant)){
			$this->dateDebut = $dateDebut;
			$this->dateFin = $dateFin;
			$this->idIntervenant = $idIntervenant;
			$this->login = $login;
			$this->idVoiture = $idVoiture;
		}
	}


// -------------------------------------------------------------------------------------------
// Getters

	public function getIdEmprunt(){return $this->idEmprunt;}
	public function getDateDebut(){return $this->dateDebut;}
	public function getDateFin(){return $this->dateFin;}
	public function getIdIntervenant(){return $this->idIntervenant;}
	public function getLogin(){return $this->login;}
	public function getIdVoiture(){return $this->idVoiture;}


// -------------------------------------------------------------------------------------------
// Setters

	//public function setIdEmprunt($idEmprunt){$this->$idEmprunt;}
	public function setDateDebut($dateDebut){$this->$dateDebut;}
	public function setDateFin($dateFin){$this->$dateFin;}
	public function setIdIntervenant($idIntervenant){$this->$idIntervenant;}
	public function setIdlogin($login){$this->$login;}
	public function setIdVoiture($idVoiture){$this->$idVoiture;}
}
?>