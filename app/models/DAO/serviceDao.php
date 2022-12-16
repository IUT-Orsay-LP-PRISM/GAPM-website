<?php
class ServiceDao extends Service{

	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// Méthodes

	// Méthode static qui affiche un Service
	public function display() {
		echo "<p>Service 
			<ul>
				<li>idService : $this->idService</li> 
        		<li>description : $this->description</li>
			</ul>
		</p>";
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui insère un Service
	public static function insertService($desc){
		$requetePreparee = "INSERT INTO Service (description) 
							VALUES (:desc_tag);";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"desc_tag"=>$desc
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
	// Méthode static qui modifie un Service
	public static function updateService($idServ, $d){
		$requetePreparee = "UPDATE Service SET description = :d_tag WHERE idService = :idServ_tag ; ";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"idServ_tag"=>$idServ, 
			"d_tag"=>$d
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
	// Méthode static qui supprime un Service
	public static function deleteService($idService){
		$requetePreparee = "DELETE FROM Service WHERE idService = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("id_tag" => $idService);
		try{
			$req_prep->execute($valeurs);
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne un Service identifié par son idService
	public static function getServiceById($idService) {
		// écriture de la requête
		$requetePreparee = "SELECT * FROM Service WHERE idService = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		// le tableau des valeurs
		$valeurs = array("id_tag" => $idService);
		try {
			// envoi de la requête
			$req_prep->execute($valeurs);
			// traitement de la réponse
		$req_prep->setFetchmode(PDO::FETCH_CLASS,'Service');
			// récupération du service
			$a = $req_prep->fetch();
			// retour
			return $a;
		} catch(PDEException $e) {
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne les Services en un tableau d'objets
	public static function getAllServices() {
		// écriture de la requête
		$requete = "SELECT * FROM Service;";
	// envoi de la requête et stockage de la réponse
		$resultat = Connexion::pdo()->query($requete);
	// traitement de la réponse
	$resultat->setFetchmode(PDO::FETCH_CLASS,'Service');
	$tableau = $resultat->fetchAll();
		return $tableau;
	}
}
?>