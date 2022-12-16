<?php
class rendezVous{

// -------------------------------------------------------------------------------------------
// Attributs
	protected $idRdv;
	protected $status;
	protected $dateRdv;
	protected $heureDebut;
	protected $heureFin;
	protected $idDemandeur;
	protected $idService;
	protected $idIntervenant;

	protected static $objet = "rendezVous";
	protected static $cle = "idRdv";


// -------------------------------------------------------------------------------------------
// Constructeur

	function __construct($status, $dateRdv, $heureDebut, $heureFin, $idDemandeur, $idService, $idIntervenant) {
		if(!is_null($idDemandeur)){
			$this->status = $status;
			$this->dateRdv = $dateRdv;
			$this->heureDebut = $heureDebut;
			$this->heureFin = $heureFin;
			$this->idDemandeur = $idDemandeur;
			$this->idService = $idService;
			$this->idIntervenant = $idIntervenant;
		}
	}


// -------------------------------------------------------------------------------------------
// Getters

	public function getIdRdv(){return $this->idRdv;}
	public function getStatus(){return $this->status;}
	public function getDateRdv(){return $this->dateRdv;}
	public function getHeureDebut(){return $this->heureDebut;}
	public function getHeureFin(){return $this->heureFin;}
	public function getIdDemandeur(){return $this->idDemandeur;}
	public function getIdService(){return $this->idService;}
	public function getIdIntervenant(){return $this->idIntervenant;}


// -------------------------------------------------------------------------------------------
// Setters

	//public function setIdRdv($idRdv){$this->$idRdv;}
	public function setStatus($status){$this->$status;}
	public function setDateRdv($dateRdv){$this->$dateRdv;}
	public function setHeureDebut($heureDebut){$this->$heureDebut;}
	public function setHeureFin($heureFin){$this->$heureFin;}
	public function setIdDemandeur($idDemandeur){$this->$idDemandeur;}
	public function setIdService($idService){$this->$idService;}
	public function setIdIntervenant($idIntervenant){$this->$idIntervenant;}
}
?>