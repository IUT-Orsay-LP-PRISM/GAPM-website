<?php

namespace App\models\dao;

use PDO;

class EmpruntDao extends ConnexionDB{

	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// Méthodes

	// Méthode static qui affiche un Emprunt
	public function display() {
		echo "<p>Emprunt 
			<ul>
				<li>idEmprunt : $this->idEmprunt</li> 
        		<li>dateDebut : $this->dateDebut</li>
        		<li>dateFin : $this->dateFin</li>
        		<li>idIntervenant : $this->idIntervenant</li>
        		<li>login : $this->login</li>
        		<li>idVoiture : $this->idVoiture</li>
			</ul>
		</p>";
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui insère un Emprunt
	public static function insertEmprunt($dateD, $dateF, $idInt, $login, $idVoi){
		$requetePreparee = "INSERT INTO Emprunt (dateDebut, dateFin, id_intervenant, login, id_voiture) 
							VALUES (:dateD_tag, :dateF_tag, :idInt_tag, :login_tag, :idVoi_tag) ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"dateD_tag"=>$dateD, 
			"dateF_tag"=>$dateF, 
			"idInt_tag"=>$idInt, 
			"login_tag"=>$login, 
			"idVoi_tag"=>$idVoi
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
	// Méthode static qui modifie un Emprunt
	public static function updateEmprunt($idEmp, $dateD, $dateF, $idInt, $login, $idVoi){
		$requetePreparee = "UPDATE Emprunt SET dateDebut = :dateD_tag, dateFin = :dateF_tag, 
        id_intervenant = :idInt_tag, login = :login_tag, id_voiture = :idVoi_tag 
        WHERE id_emprunt = :idEmp_tag ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"idEmp_tag"=>$idEmp, 
			"dateD_tag"=>$dateD, 
			"dateF_tag"=>$dateF, 
			"idInt_tag"=>$idInt, 
			"login_tag"=>$login, 
			"idVoi_tag"=>$idVoi
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
	// Méthode static qui supprime un Emprunt
	public static function deleteEmprunt($idEmprunt){
		$requetePreparee = "DELETE FROM Emprunt WHERE idEmprunt = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("id_tag" => $idEmprunt);
		try{
			$req_prep->execute($valeurs);
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne un Emprunt identifié par son idEmprunt
	public static function getEmpruntById($idEmprunt) {
		// écriture de la requête
		$requetePreparee = "SELECT * FROM Emprunt WHERE idEmprunt = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		// le tableau des valeurs
		$valeurs = array("id_tag" => $idEmprunt);
		try {
			// envoi de la requête
			$req_prep->execute($valeurs);
			// traitement de la réponse
		$req_prep->setFetchmode(PDO::FETCH_CLASS,'App\models\entity\Emprunt');
			// récupération de l'emprunt
			$a = $req_prep->fetch();
			// retour
			return $a;
		} catch(PDEException $e) {
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne les Emprunts en un tableau d'objets
	public static function getAllEmprunts() {
		// écriture de la requête
		$requete = "SELECT * FROM Emprunt;";
	// envoi de la requête et stockage de la réponse
		$resultat = Connexion::pdo()->query($requete);
	// traitement de la réponse
	$resultat->setFetchmode(PDO::FETCH_CLASS,'App\models\entity\Emprunt');
	$tableau = $resultat->fetchAll();
		return $tableau;
	}
}
?>