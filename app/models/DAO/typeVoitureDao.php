<?php

namespace App\models\dao;

use PDO;

class TypeVoitureDao extends ConnexionDB{

	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// Méthodes

	public function display() {
		echo "<p>TypeVoiture 
			<ul>
				<li>idTypeVoiture : $this->idTypeVoiture</li> 
        		<li>modele : $this->modele</li>
			</ul>
		</p>";
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui insère un TypeVoiture
	public static function insertTypeVoiture($mod){
		$requetePreparee = "INSERT INTO TypeVoiture (modele) 
							VALUES (:mod_tag) ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"mod_tag"=>$mod
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
	// Méthode static qui modifie un TypeVoiture
	public static function updateTypeVoiture($idTypeV, $mod){
		$requetePreparee = "UPDATE TypeVoiture SET modele = :mod_tag WHERE id_typeVoiture = :idTypeV_tag ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"idTypeV_tag"=>$idTypeV, 
			"mod_tag"=>$mod
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
	// Méthode static qui supprime un TypeVoiture
	public static function deleteTypeVoiture($idTypeVoiture){
		$requetePreparee = "DELETE FROM TypeVoiture WHERE idTypeVoiture = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("id_tag" => $idTypeVoiture);
		try{
			$req_prep->execute($valeurs);
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne un TypeVoiture identifié par son idTypeVoiture
	public static function getTypeVoitureById($idTypeVoiture) {
		// écriture de la requête
		$requetePreparee = "SELECT * FROM TypeVoiture WHERE idTypeVoiture = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		// le tableau des valeurs
		$valeurs = array("id_tag" => $idTypeVoiture);
		try {
			// envoi de la requête
			$req_prep->execute($valeurs);
			// traitement de la réponse
		$req_prep->setFetchmode(PDO::FETCH_CLASS,'App\models\entity\TypeVoiture');
			// récupération du type de la voiture
			$a = $req_prep->fetch();
			// retour
			return $a;
		} catch(PDEException $e) {
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne les TypeVoiture en un tableau d'objets
	public static function getAllTypeVoiture() {
		// écriture de la requête
		$requete = "SELECT * FROM TypeVoiture;";
	// envoi de la requête et stockage de la réponse
		$resultat = Connexion::pdo()->query($requete);
	// traitement de la réponse
	$resultat->setFetchmode(PDO::FETCH_CLASS,'App\models\entity\TypeVoiture');
	$tableau = $resultat->fetchAll();
		return $tableau;
	}
}
?>