<?php
class CommentaireDao extends Commentaire{

	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// Méthodes

	// Méthode static qui affiche un Commentaire
	public function display() {
		echo "<p>Commentaire 
			<ul>
				<li>idCommentaire : $this->idCommentaire</li> 
        		<li>description : $this->description</li>
        		<li>note : $this->note</li>
        		<li>idRdv : $this->idRdv</li>
        		<li>idDemandeur : $this->idDemandeur</li>
			</ul>
		</p>";
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui insère un Commentaire
	public static function insertCommentaire($d, $n, $idRdv, $idDeman){
		$requetePreparee = "INSERT INTO Commentaire (description, note, idRdv, idDemandeur) 
							VALUES (:d_tag, :n_tag, :idRdv_tag, :idDeman_tag) ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"d_tag"=>$d, 
			"n_tag"=>$n, 
			"idRdv_tag"=>$idRdv, 
			"idDeman_tag"=>$idDeman
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
	// Méthode static qui modifie un Commentaire
	public static function updateCommentaire($idCom, $d, $n, $idRdv, $idDeman){
		$requetePreparee = "UPDATE Commentaire SET description = :d_tag, note = :n_tag, 
		idRdv = :idRdv_tag, idDemandeur = :idDeman_tag WHERE idCommentaire = :idCom_tag ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"idCom_tag"=>$idCom, 
			"d_tag"=>$d, 
			"n_tag"=>$n, 
			"idRdv_tag"=>$idRdv, 
			"idDeman_tag"=>$idDeman
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
	// Méthode static qui supprime un Commentaire
	public static function deleteCommentaire($idCommentaire){
		$requetePreparee = "DELETE FROM Commentaire WHERE idCommentaire = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("id_tag" => $idCommentaire);
		try{
			$req_prep->execute($valeurs);
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne un Commentaire identifié par son idCommentaire
	public static function getCommentaireById($idCommentaire) {
		// écriture de la requête
		$requetePreparee = "SELECT * FROM Commentaire WHERE idCommentaire = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		// le tableau des valeurs
		$valeurs = array("id_tag" => $idCommentaire);
		try {
			// envoi de la requête
			$req_prep->execute($valeurs);
			// traitement de la réponse
		$req_prep->setFetchmode(PDO::FETCH_CLASS,'Commentaire');
			// récupération du commentaire
			$a = $req_prep->fetch();
			// retour
			return $a;
		} catch(PDEException $e) {
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne les Commentaires en un tableau d'objets
	public static function getAllCommentaires() {
		// écriture de la requête
		$requete = "SELECT * FROM Commentaire;";
	// envoi de la requête et stockage de la réponse
		$resultat = Connexion::pdo()->query($requete);
	// traitement de la réponse
	$resultat->setFetchmode(PDO::FETCH_CLASS,'Commentaire');
	$tableau = $resultat->fetchAll();
		return $tableau;
	}
}
?>