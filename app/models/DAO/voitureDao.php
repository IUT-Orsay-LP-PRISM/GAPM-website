<?php

namespace App\models\dao;

use PDO;

class VoitureDao extends ConnexionDB{

	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// Méthodes

	// Méthode static qui affiche une Voiture
	public function afficher() {
		echo "<p>Voiture 
			<ul>
				<li>idVoiture : $this->idVoiture</li> 
        		<li>immatriculation : $this->immatriculation</li>
        		<li>idTypeVoiture : $this->idTypeVoiture</li>
			</ul>
		</p>";
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui insère une Voiture
	public static function insertVoiture($imma, $idTypeVoi){
		$requetePreparee = "INSERT INTO Voiture (immatriculation, id_typeVoiture) 
							VALUES (:imma_tag, :idTypeVoi_tag) ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"imma_tag"=>$imma, 
			"idTypeVoi_tag"=>$idTypeVoi
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
	// Méthode static qui modifie une Voiture
	public static function updateVoiture($idVoi, $imma, $idTypeVoi){
		$requetePreparee = "UPDATE Voiture SET immatriculation = :imma_tag, id_typeVoiture = :idTypeVoi_tag
		WHERE id_voiture = :idVoi_tag ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"idVoi_tag"=>$idVoi, 
			"imma_tag"=>$imma, 
			"idTypeVoi_tag"=>$idTypeVoi
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
	// Méthode static qui supprime une Voiture
	public static function deleteVoiture($idVoiture){
		$requetePreparee = "DELETE FROM Voiture WHERE idVoiture = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("id_tag" => $idVoiture);
		try{
			$req_prep->execute($valeurs);
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne une Voiture identifié par son idVoiture
	public static function getVoitureById($idVoiture) {
		// écriture de la requête
		$requetePreparee = "SELECT * FROM Voiture WHERE idVoiture = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		// le tableau des valeurs
		$valeurs = array("id_tag" => $idVoiture);
		try {
			// envoi de la requête
			$req_prep->execute($valeurs);
			// traitement de la réponse
		$req_prep->setFetchmode(PDO::FETCH_CLASS,'App\models\entity\Voiture');
			// récupération de la voiture
			$a = $req_prep->fetch();
			// retour
			return $a;
		} catch(PDEException $e) {
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne les Voitures en un tableau d'objets
	public static function getAllVoitures() {
		// écriture de la requête
		$requete = "SELECT * FROM Voiture;";
	// envoi de la requête et stockage de la réponse
		$resultat = Connexion::pdo()->query($requete);
	// traitement de la réponse
	$resultat->setFetchmode(PDO::FETCH_CLASS,'App\models\entity\Voiture');
	$tableau = $resultat->fetchAll();
		return $tableau;
	}
}
?>