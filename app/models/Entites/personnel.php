<?php
class Personnel{

// -------------------------------------------------------------------------------------------
// Attributs
	protected $login;
	protected $nom;
	protected $prenom;
	protected $motDePasse;
	protected $email;

	protected static $objet = "Personnel";
	protected static $cle = "login";



// -------------------------------------------------------------------------------------------
// Constructeur

	function __construct($nom, $prenom, $motDePasse, $email) {
		if(!is_null($nom)){
			$this->nom = $nom;
			$this->prenom = $prenom;
			$this->motDePasse = $motDePasse;
			$this->email = $email;
		}
	}


// -------------------------------------------------------------------------------------------
// Getters

	public function getLogin(){return $this->login;}
	public function getNom(){return $this->nom;}
	public function getPrenom(){return $this->prenom;}
	public function getMotDePasse(){return $this->motDePasse;}
	public function getEmail(){return $this->email;}


// -------------------------------------------------------------------------------------------
// Setters

	//public function setLogin($login){$this->$login;}
	public function setNom($nom){$this->$nom;}
	public function setPrenom($prenom){$this->$prenom;}
	public function setMotDePasse($motDePasse){$this->$motDePasse;}
	public function setEmail($email){$this->$email;}
}
?>