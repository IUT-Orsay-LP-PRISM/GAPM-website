<?php
class FichePaieDao extends FichePaie{

	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// Méthodes

	// Méthode static qui affiche une FichePaie
	public function display() {
		echo "<p>Fiche Paie 
			<ul>
				<li>idFichePaie : $this->idFichePaie</li> 
        		<li>url : $this->url</li>
        		<li>idIntervenant : $this->idIntervenant</li>
        		<li>login : $this->login</li>
			</ul>
		</p>";
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui insère une FichePaie
	public static function insertFichePaie($url, $idInt, $idLogin){
		$requetePreparee = "INSERT INTO Fiche_Paie (url, id_intervenant, login) 
							VALUES (:url_tag, :idInt_tag, :idLogin_tag) ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"url_tag"=>$url, 
			"idInt_tag"=>$idInt, 
			"idLogin_tag"=>$idLogin
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
	// Méthode static qui modifie une FichePaie
	public static function updateFichePaie($idFP, $url, $idInt, $idLogin){
		$requetePreparee = "UPDATE Fiche_Paie SET url = :url_tag, id_intervenant = :idInt_tag, 
		login = :idLogin_tag WHERE id_fiche_paie = :idFP_tag ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"idFP_tag"=>$idFP, 
			"url_tag"=>$url, 
			"idInt_tag"=>$idInt, 
			"idLogin_tag"=>$idLogin
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
	// Méthode static qui supprime une FichePaie
	public static function deleteFichePaie($idFichePaie){
		$requetePreparee = "DELETE FROM FichePaie WHERE idFichePaie = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("id_tag" => $idFichePaie);
		try{
			$req_prep->execute($valeurs);
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne une FichePaie identifié par son idFichePaie
	public static function getFichePaieById($idFichePaie) {
		// écriture de la requête
		$requetePreparee = "SELECT * FROM FichePaie WHERE idFichePaie = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		// le tableau des valeurs
		$valeurs = array("id_tag" => $idFichePaie);
		try {
			// envoi de la requête
			$req_prep->execute($valeurs);
			// traitement de la réponse
		$req_prep->setFetchmode(PDO::FETCH_CLASS,'FichePaie');
			// récupération de la fiche de paie
			$a = $req_prep->fetch();
			// retour
			return $a;
		} catch(PDEException $e) {
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne les FichePaie en un tableau d'objets
	public static function getAllFichePaies() {
		// écriture de la requête
		$requete = "SELECT * FROM FichePaie;";
	// envoi de la requête et stockage de la réponse
		$resultat = Connexion::pdo()->query($requete);
	// traitement de la réponse
	$resultat->setFetchmode(PDO::FETCH_CLASS,'FichePaie');
	$tableau = $resultat->fetchAll();
		return $tableau;
	}
}
?>