<?php

namespace App\models\dao;

use PDO;

class NoteFraisDao extends ConnexionDB{

	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// Méthodes

	// Méthode static qui affiche une NoteFrais
	public function display() {
		echo "<p>Note Frais 
			<ul>
				<li>idNoteFrais : $this->idNoteFrais</li> 
        		<li>dateNote : $this->dateNote</li>
        		<li>description : $this->description</li>
        		<li>URLJustificatif : $this->URLJustificatif</li>
        		<li>montant : $this->montant</li>
        		<li>status : $this->status</li>
        		<li>login : $this->login</li>
			</ul>
		</p>";
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui insère une NoteFrais
	public static function insertNoteFrais($date, $desc, $url, $mont, $stat, $login){
		$requetePreparee = "INSERT INTO Note_Frais (dateNote, description, URLJustificatif, 
                            montant, status, login) 
							VALUES (:date_tag, :desc_tag, :url_tag, :mont_tag, :stat_tag, :login_tag) ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"date_tag"=>$date, 
			"desc_tag"=>$desc, 
			"url_tag"=>$url, 
			"mont_tag"=>$mont, 
			"stat_tag"=>$stat, 
			"login_tag"=>$login
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
	// Méthode static qui modifie une NoteFrais
	public static function updateNoteFrais($idNoteFrais, $date, $desc, $url, $mont, $stat, $login){
		$requetePreparee = "UPDATE Note_Frais SET dateNote = :date_tag, description = :desc_tag, 
        URLJustificatif = :url_tag, montant = :mont_tag, status = :stat_tag, login = :login_tag
		WHERE idNoteFrais = :idNote_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"idNote_tag"=>$idNoteFrais, 
			"date_tag"=>$date, 
			"desc_tag"=>$desc, 
			"url_tag"=>$url, 
			"mont_tag"=>$mont, 
			"stat_tag"=>$stat, 
			"login_tag"=>$login
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
	// Méthode static qui supprime une NoteFrais
	public static function deleteNoteFrais($idNoteFrais){
		$requetePreparee = "DELETE FROM NoteFrais WHERE idNoteFrais = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("id_tag" => $idNoteFrais);
		try{
			$req_prep->execute($valeurs);
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne une NoteFrais identifié par son idNoteFrais
	public static function getNoteFraisById($idNoteFrais) {
		// écriture de la requête
		$requetePreparee = "SELECT * FROM NoteFrais WHERE idNoteFrais = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		// le tableau des valeurs
		$valeurs = array("id_tag" => $idNoteFrais);
		try {
			// envoi de la requête
			$req_prep->execute($valeurs);
			// traitement de la réponse
		$req_prep->setFetchmode(PDO::FETCH_CLASS,'App\models\entity\NoteFrais');
			// récupération de la note de frais
			$a = $req_prep->fetch();
			// retour
			return $a;
		} catch(PDEException $e) {
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne les NoteFraiss en un tableau d'objets
	public static function getAllNoteFrais() {
		// écriture de la requête
		$requete = "SELECT * FROM NoteFrais;";
	// envoi de la requête et stockage de la réponse
		$resultat = Connexion::pdo()->query($requete);
	// traitement de la réponse
	$resultat->setFetchmode(PDO::FETCH_CLASS,'App\models\entity\NoteFrais');
	$tableau = $resultat->fetchAll();
		return $tableau;
	}
}
?>