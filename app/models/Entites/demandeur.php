<?php
class Demandeur{

// -------------------------------------------------------------------------------------------
// Attributs
	protected $idDemandeur;
	protected $login;
	protected $motDePasse;
	protected $nom;
	protected $prenom;
	protected $dateNaissance;
	protected $adresse;
	protected $telephone;
	protected $sexe;
	protected $idVille;

	protected static $objet = "Demandeur";
	protected static $cle = "idDemandeur";


// -------------------------------------------------------------------------------------------
// Constructeur

	function __construct($login, $motDePasse, $nom, $prenom, $dateNaissance, $adresse, 
						 $telephone, $sexe, $idVille) {
		if(!is_null($login)){
			$this->login = $login;
			$this->motDePasse = $motDePasse;
			$this->nom = $nom;
			$this->prenom = $prenom;
			$this->dateNaissance = $dateNaissance;
			$this->adresse = $adresse;
			$this->telephone = $telephone;
			$this->sexe = $sexe;
			$this->idVille = $idVille;
		}
	}


// -------------------------------------------------------------------------------------------
// Getters

	public function getIdDemandeur(){return $this->idDemandeur;}
	public function getLogin(){return $this->login;}
	public function getMotDePasse(){return $this->motDePasse;}
	public function getNom(){return $this->nom;}
	public function getPrenom(){return $this->prenom;}
	public function getDateNaissance(){return $this->dateNaissance;}
	public function getAdresse(){return $this->adresse;}
	public function getTelephone(){return $this->telephone;}
	public function getSexe(){return $this->sexe;}
	public function getIdVille(){return $this->idVille;}


// -------------------------------------------------------------------------------------------
// Setters

	//public function setIdDemandeur($idDemandeur){$this->$idDemandeur;}
	public function setLogin($login){$this->$login;}
	public function setMotDePasse($motDePasse){$this->$motDePasse;}
	public function setNom($nom){$this->$nom;}
	public function setPrenom($prenom){$this->$prenom;}
	public function setDateNaissance($dateNaissance){$this->$dateNaissance;}
	public function setAdresse($adresse){$this->$adresse;}
	public function setTelephone($telephone){$this->$telephone;}
	public function setSexe($sexe){$this->$sexe;}
	public function setIdVille($idVille){$this->$idVille;}
}
?>