<?php

namespace App\models\dao;

use PDO;

class PersonnelDao extends ConnexionDB{

	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// Méthodes

	// Méthode static qui affiche un Personnel
	public function display() {
		echo "<p>Personnel 
			<ul>
				<li>login : $this->login</li> 
        		<li>nom : $this->nom</li>
        		<li>prenom : $this->prenom</li>
        		<li>motDePasse : $this->motDePasse</li>
        		<li>email : $this->email</li>
			</ul>
		</p>";
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui insère un Personnel
	public static function insertPersonnel($nom, $prenom, $mdp, $email){
		$requetePreparee = "INSERT INTO Personnel (nom, prenom, motDePasse, email) 
							VALUES (:nom_tag, :prenom_tag, :mdp_tag, :email_tag) ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"nom_tag"=>$nom, 
			"prenom_tag"=>$prenom, 
			"mdp_tag"=>$mdp, 
			"email_tag"=>$email
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
	// Méthode static qui modifie un Personnel
	public static function updatePersonnel($login, $nom, $prenom, $mdp, $email){
		$requetePreparee = "UPDATE Personnel SET nom = :nom_tag, prenom = :prenom_tag, 
		motDePasse = :mdp_tag, email = :email_tag WHERE login = :login_tag ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"login_tag"=>$login, 
			"nom_tag"=>$nom, 
			"prenom_tag"=>$prenom, 
			"mdp_tag"=>$mdp, 
			"email_tag"=>$email
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
	// Méthode static qui supprime un Personnel
	public static function deletePersonnel($idPersonnel){
		$requetePreparee = "DELETE FROM Personnel WHERE idPersonnel = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("id_tag" => $idPersonnel);
		try{
			$req_prep->execute($valeurs);
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne un Personnel identifié par son idPersonnel
	public static function getPersonnelById($idPersonnel) {
		// écriture de la requête
		$requetePreparee = "SELECT * FROM Personnel WHERE idPersonnel = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		// le tableau des valeurs
		$valeurs = array("id_tag" => $idPersonnel);
		try {
			// envoi de la requête
			$req_prep->execute($valeurs);
			// traitement de la réponse
		$req_prep->setFetchmode(PDO::FETCH_CLASS,'App\models\entity\Personnel');
			// récupération du personnel
			$a = $req_prep->fetch();
			// retour
			return $a;
		} catch(PDEException $e) {
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne les Personnels en un tableau d'objets
	public static function getAllPersonnels() {
		// écriture de la requête
		$requete = "SELECT * FROM Personnel;";
	// envoi de la requête et stockage de la réponse
		$resultat = Connexion::pdo()->query($requete);
	// traitement de la réponse
	$resultat->setFetchmode(PDO::FETCH_CLASS,'App\models\entity\Personnel');
	$tableau = $resultat->fetchAll();
		return $tableau;
	}
}
?>