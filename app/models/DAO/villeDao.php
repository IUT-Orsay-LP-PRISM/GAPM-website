<?php
class VilleDao extends Ville{

	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// Méthodes

	// Méthode static qui affiche une Ville
	public function display() {
		echo "<p>Ville 
			<ul>
				<li>idVille : $this->idVille</li> 
        		<li>nom : $this->nom</li>
        		<li>codePostal : $this->codePostal</li>
			</ul>
		</p>";
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui insère une Ville
	public static function insertVille($nom, $codePostal){
		$requetePreparee = "INSERT INTO Ville (nom, codePostal) 
							VALUES (:n_tag, :nom_tag, :cp_tag) ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"nom_tag"=>$nom, 
			"cp_tag"=>$codePostal
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
	// Méthode static qui modifie une Ville
	public static function updateVille($idVille, $nom, $codePostal){
		$requetePreparee = "UPDATE Ville SET nom = :nom_tag, codePostal = :cp_tag
        WHERE id_ville = :idVille_tag ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"idVille_tag"=>$idVille, 
			"nom_tag"=>$nom, 
			"cp_tag"=>$codePostal
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
	// Méthode static qui supprime une Ville
	public static function deleteVille($idVille){
		$requetePreparee = "DELETE FROM Ville WHERE idVille = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("id_tag" => $idVille);
		try{
			$req_prep->execute($valeurs);
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne un Ville identifié par son idVille
	public static function getVilleById($idVille) {
		// écriture de la requête
		$requetePreparee = "SELECT * FROM Ville WHERE idVille = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		// le tableau des valeurs
		$valeurs = array("id_tag" => $idVille);
		try {
			// envoi de la requête
			$req_prep->execute($valeurs);
			// traitement de la réponse
		$req_prep->setFetchmode(PDO::FETCH_CLASS,'Ville');
			// récupération de la ville
			$a = $req_prep->fetch();
			// retour
			return $a;
		} catch(PDEException $e) {
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne les Villes en un tableau d'objets
	public static function getAllVilles() {
		// écriture de la requête
		$requete = "SELECT * FROM Ville;";
	// envoi de la requête et stockage de la réponse
		$resultat = Connexion::pdo()->query($requete);
	// traitement de la réponse
	$resultat->setFetchmode(PDO::FETCH_CLASS,'Ville');
	$tableau = $resultat->fetchAll();
		return $tableau;
	}
}
?>