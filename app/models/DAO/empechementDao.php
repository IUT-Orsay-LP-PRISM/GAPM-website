<?php
class EmpechementDao extends Empechement{
	
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// Méthodes

	// Méthode static qui affiche un Empechement
	public function display() {
		echo "<p>Empechement 
			<ul>
				<li>idEmpechement : $this->idEmpechement</li> 
        		<li>dateDebut : $this->dateDebut</li>
        		<li>dateFin : $this->dateFin</li>
        		<li>idIntervenant : $this->idIntervenant</li>
			</ul>
		</p>";
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui insère un Empechement
	public static function insertEmpechement($dateD, $dateF, $idInt){
		$requetePreparee = "INSERT INTO Empechement (dateDebut, dateFin, id_intervenant) 
							VALUES (:dateD_tag, :dateF_tag, :idInt_tag) ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"dateD_tag"=>$d, 
			"dateF_tag"=>$n, 
			"idInt_tag"=>$idRdv
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
	// Méthode static qui modifie un Empechement
	public static function updateEmpechement($idEmp, $dateD, $dateF, $idInt){
		$requetePreparee = "UPDATE Empechement SET dateDebut = :dateD_tag, dateFin = :dateF_tag, 
		id_intervenant = :idInt_tag WHERE id_empechement = :idEmp_tag ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"idEmp_tag"=>$idCom, 
			"dateD_tag"=>$d, 
			"dateF_tag"=>$n, 
			"idInt_tag"=>$idRdv
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
	// Méthode static qui supprime un Empechement
	public static function deleteEmpechement($idEmpechement){
		$requetePreparee = "DELETE FROM Empechement WHERE idEmpechement = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("id_tag" => $idEmpechement);
		try{
			$req_prep->execute($valeurs);
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne un Empechement identifié par son idEmpechement
	public static function getEmpechementById($idEmpechement) {
		// écriture de la requête
		$requetePreparee = "SELECT * FROM Empechement WHERE idEmpechement = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		// le tableau des valeurs
		$valeurs = array("id_tag" => $idEmpechement);
		try {
			// envoi de la requête
			$req_prep->execute($valeurs);
			// traitement de la réponse
		$req_prep->setFetchmode(PDO::FETCH_CLASS,'Empechement');
			// récupération de l'empechement
			$a = $req_prep->fetch();
			// retour
			return $a;
		} catch(PDEException $e) {
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne les Empechement en un tableau d'objets
	public static function getAllEmpechements() {
		// écriture de la requête
		$requete = "SELECT * FROM Empechement;";
	// envoi de la requête et stockage de la réponse
		$resultat = Connexion::pdo()->query($requete);
	// traitement de la réponse
	$resultat->setFetchmode(PDO::FETCH_CLASS,'Empechement');
	$tableau = $resultat->fetchAll();
		return $tableau;
	}
}
?>