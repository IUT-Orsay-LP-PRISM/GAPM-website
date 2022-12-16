<?php

namespace App\models\entity;

class Commentaire{

// -------------------------------------------------------------------------------------------
// Attributs
	protected $idCommentaire;
	protected $description;
	protected $note;
	protected $idRdv;
	protected $idDemandeur;

	protected static $objet = "Commentaire";
	protected static $cle = "idCommentaire";


// -------------------------------------------------------------------------------------------
// Constructeur

	function __construct($description, $note, $idRdv, $idDemandeur) {
		if(!is_null($idDemandeur)){
			$this->description = $description;
			$this->note = $note;
			$this->idRdv = $idRdv;
			$this->idDemandeur = $idDemandeur;
		}
	}


// -------------------------------------------------------------------------------------------
// Getters

	public function getIdCommentaire(){return $this->idCommentaire;}
	public function getDescription(){return $this->description;}
	public function getNote(){return $this->note;}
	public function getIdRdv(){return $this->idRdv;}
	public function getIdDemandeur(){return $this->idDemandeur;}


// -------------------------------------------------------------------------------------------
// Setters

	//public function setIdCommentaire($idCommentaire){$this->$idCommentaire;}
	public function setDescription($description){$this->$description;}
	public function setNote($note){$this->$note;}
	public function setIdRdv($idRdv){$this->$idRdv;}
	public function setIdDemandeur($idDemandeur){$this->$idDemandeur;}
}
?>