<?php
class RendezVousDao extends RendezVous{

	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// Méthodes

	// Méthode static qui affiche un RendezVous
	public function display() {
		echo "<p>Rendez-vous 
			<ul>
				<li>idRdv : $this->idRdv</li> 
        		<li>status : $this->status</li>
        		<li>dateRdv : $this->dateRdv</li>
        		<li>heureDebut : $this->heureDebut</li>
        		<li>heureFin : $this->heureFin</li>
        		<li>idDemandeur : $this->idDemandeur</li>
        		<li>idService : $this->idService</li>
        		<li>idIntervenant : $this->idIntervenant</li>
			</ul>
		</p>";
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui insère un RendezVous
	public static function insertRendezVous($stat, $date, $heureD, $heureF, $idDem, $idServ, $idInt){
		$requetePreparee = "INSERT INTO Rendez_vous (status, dateRdv, heureDebut, heureFin, id_demandeur, 
							id_service, id_intervenant) 
							VALUES (:stat_tag, :date_tag, :heureD_tag, :heureF_tag, :idDem_tag, 
							:idServ_tag, :idInt_tag) ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"stat_tag"=>$stat, 
			"date_tag"=>$date, 
			"heureD_tag"=>$heureD, 
			"heureF_tag"=>$heureF, 
			"idDem_tag"=>$idDem, 
			"idServ_tag"=>$idServ, 
			"idInt_tag"=>$idInt
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
	// Méthode static qui modifie un RendezVous
	public static function updateRendezVous($idRdv, $stat, $date, $heureD, $heureF, $idDem, $idServ, $idInt){
		$requetePreparee = "UPDATE Rendez_vous SET status = :stat_tag, dateRdv = :date_tag, 
		heureDebut = :heureD_tag, heureFin = :heureF_tag, id_demandeur = :idDem_tag, 
		id_service = :idServ_tag, id_intervenant = :idInt_tag WHERE id_rdv = :idRdv_tag ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"idRdv_tag"=>$idRdv, 
			"stat_tag"=>$stat, 
			"date_tag"=>$date, 
			"heureD_tag"=>$heureD, 
			"heureF_tag"=>$heureF, 
			"idDem_tag"=>$idDem, 
			"idServ_tag"=>$idServ, 
			"idInt_tag"=>$idInt
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
	// Méthode static qui supprime un RendezVous
	public static function deleteRendezVous($RendezVous){
		$requetePreparee = "DELETE FROM RendezVous WHERE idRendezVous = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("id_tag" => $idRendezVous);
		try{
			$req_prep->execute($valeurs);
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne un RendezVous identifié par son idRendezVous
	public static function getRendezVousById($idRendezVous) {
		// écriture de la requête
		$requetePreparee = "SELECT * FROM RendezVous WHERE idARendezVous = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		// le tableau des valeurs
		$valeurs = array("id_tag" => $idRendezVous);
		try {
			// envoi de la requête
			$req_prep->execute($valeurs);
			// traitement de la réponse
		$req_prep->setFetchmode(PDO::FETCH_CLASS,'RendezVous');
			// récupération du rendezVous
			$a = $req_prep->fetch();
			// retour
			return $a;
		} catch(PDEException $e) {
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne les RendezVouss en un tableau d'objets
	public static function getAllRendezVous() {
		// écriture de la requête
		$requete = "SELECT * FROM RendezVous;";
	// envoi de la requête et stockage de la réponse
		$resultat = Connexion::pdo()->query($requete);
	// traitement de la réponse
	$resultat->setFetchmode(PDO::FETCH_CLASS,'RendezVous');
	$tableau = $resultat->fetchAll();
		return $tableau;
	}
}
?>