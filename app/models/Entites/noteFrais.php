<?php
class NoteFrais{

// -------------------------------------------------------------------------------------------
// Attributs
	protected $idNoteFrais;
	protected $dateNote;
	protected $description;
	protected $urlJustificatif;
	protected $montant;
	protected $status;
	protected $login;

	protected static $objet = "NoteFrais";
	protected static $cle = "idNoteFrais";


// -------------------------------------------------------------------------------------------
// Constructeur

	function __construct($dateNote, $description, $urlJustificatif, $montant, $status, $login) {
		if(!is_null($login)){
		$this->dateNote = $dateNote;
		$this->description = $description;
		$this->urlJustificatif = $urlJustificatif;
		$this->montant = $montant;
		$this->status = $status;
		$this->login = $login;
		}
	}


// -------------------------------------------------------------------------------------------
// Getters

	public function getIdNoteFrais(){return $this->idNoteFrais;}
	public function getDateNote(){return $this->dateNote;}
	public function getDescription(){return $this->description;}
	public function getUrlJustificatif(){return $this->urlJustificatif;}
	public function getMontant(){return $this->montant;}
	public function getStatus(){return $this->status;}
	public function getLogin(){return $this->login;}


// -------------------------------------------------------------------------------------------
// Setters

	//public function setIdNoteFrais($idNoteFrais){$this->$idNoteFrais;}
	public function setDateNote($dateNote){$this->$dateNote;}
	public function setDescription($description){$this->$description;}
	public function setUrlJustificatif($urlJustificatif){$this->$urlJustificatif;}
	public function setMontant($montant){$this->$montant;}
	public function setStatus($status){$this->$status;}
	public function setLogin($login){$this->$login;}
}
?>