<?php

namespace App\models\entity;

class Service{

// -------------------------------------------------------------------------------------------
// Attributs
	protected $idService;
	protected $description;

	protected static $objet = "Service";
	protected static $cle = "idService";


// -------------------------------------------------------------------------------------------
// Constructeur

	function __construct($description) {
		if(!is_null($description)){
			$this->description = $description;
		}
	}


// -------------------------------------------------------------------------------------------
// Getters

	public function getIdService(){return $this->idService;}
	public function getDescription(){return $this->description;}


// -------------------------------------------------------------------------------------------
// Setters

	//public function setIdService($idService){$this->$idService;}
	public function setDescription($description){$this->$description;}
}
?>