<?php

namespace App\models\dao;

use PDO;

class AdministrateurDao extends ConnexionDB{

	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// Méthodes

	// Méthode static qui affiche un Administrateur
	public function display() {
		echo "<p>Administrateur 
			<ul>
				<li>idAdministrateur : $this->idAdministrateur</li> 
        		<li>login : $this->login</li>
        		<li>nom : $this->nom</li>
        		<li>prenom : $this->prenom</li>
        		<li>motDePasse : $this->motDePasse</li>
			</ul>
		</p>";
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui insère un Administrateur
	public static function insertAdministrateur($login, $nom, $prenom, $mdp){
		$requetePreparee = "INSERT INTO Administrateur (login, nom, prenom, motDePasse) 
							VALUES (:login_tag, :nom_tag, :prenom_tag, :mdp_tag) ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array( 
			"login_tag"=>$login, 
			"nom_tag"=>$nom, 
			"prenom_tag"=>$prenom, 
			"mdp_tag"=>$mdp
		);
		try{
		  $req_prep->execute($valeurs);
		  return true;
		} catch(PDOException $e){
		  	echo $e;
			die();
		  	return false;
		}
	}
	

	// -------------------------------------------------------------------------------------------
	// Méthode static qui modifie un Administrateur
	public static function updateAdministrateur($idAdmin, $login, $nom, $prenom, $mdp){
		$requetePreparee = "UPDATE Administrateur SET login = :login_tag, nom = :nom_tag, 
        prenom = :prenom_tag, motDePasse = :mdp_tag WHERE id_Administrateur = :idAdmin_tag ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"idAdmin_tag"=>$idAdmin, 
			"login_tag"=>$login, 
			"nom_tag"=>$nom, 
			"prenom_tag"=>$prenom, 
			"mdp_tag"=>$mdp
		);
		try{
			//echo $requetePreparee;
			$req_prep->execute($valeurs);
			//echo "<pre>"; var_dump($req_prep); echo "</pre>";
			return true;
		} catch(PDOException $e){
			echo $e;
			die();
			return false;
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui supprime un Administrateur
	public static function deleteAdministrateur($idAdministrateur){
		$requetePreparee = "DELETE FROM Administrateur WHERE idAdministrateur = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("id_tag" => $idAdministrateur);
		try{
			$req_prep->execute($valeurs);
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne un Administrateur identifié par son idAdministrateur
	public static function getAdministrateurById($idAdministrateur) {
		// écriture de la requête
		$requetePreparee = "SELECT * FROM Administrateur WHERE idAdministrateur = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		// le tableau des valeurs
		$valeurs = array("id_tag" => $idAdministrateur);
		try {
			// envoi de la requête
			$req_prep->execute($valeurs);
			// traitement de la réponse
		$req_prep->setFetchmode(PDO::FETCH_CLASS,'App\models\entity\Administrateur');
			// récupération de l'administrateur
			$a = $req_prep->fetch();
			// retour
			return $a;
		} catch(PDEException $e) {
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne les Administrateurs en un tableau d'objets
	public static function getAllAdministrateurs() {
		// écriture de la requête
		$requete = "SELECT * FROM Administrateur;";
	// envoi de la requête et stockage de la réponse
		$resultat = Connexion::pdo()->query($requete);
	// traitement de la réponse
	$resultat->setFetchmode(PDO::FETCH_CLASS,'App\models\entity\Administrateur');
	$tableau = $resultat->fetchAll();
		return $tableau;
	}
}
?>