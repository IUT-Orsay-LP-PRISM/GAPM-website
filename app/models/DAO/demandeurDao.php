<?php
class DemandeurDao extends Demandeur{

	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// Méthodes

	// Méthode static qui affiche un Demandeur
	public function display() {
		echo "<p>Demandeur 
			<ul>
				<li>idDemandeur : $this->idDemandeur</li> 
        		<li>login : $this->login</li>
        		<li>motDePasse : $this->motDePasse</li>
        		<li>nom : $this->nom</li>
        		<li>prenom : $this->prenom</li>
        		<li>dateNaissance : $this->dateNaissance</li>
        		<li>adresse : $this->adresse</li>
        		<li>telephone : $this->telephone</li>
        		<li>sexe : $this->sexe</li>
        		<li>idVille : $this->idVille</li>
			</ul>
		</p>";
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui insère un Demandeur
	public static function insertDemandeur($login, $mdp, $nom, $prenom, $dateNais,
                            $adresse, $tel, $sexe, $idVille){
		$requetePreparee = "INSERT INTO Demandeur (login, motDePasse, nom, prenom, dateNaissance, 
                            adresse, telephone, sexe, id_ville) 
							VALUES (:login_tag, :mdp_tag, :nom_tag, :prenom_tag, :dateNais_tag, 
                            :adresse_tag, :tel_tag, :sexe_tag, :idville_tag) ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"login_tag"=>$login, 
			"mdp_tag"=>$mdp, 
			"nom_tag"=>$nom, 
			"prenom_tag"=>$prenom, 
			"dateNais_tag"=>$dateNais, 
			"adresse_tag"=>$adresse, 
			"tel_tag"=>$tel, 
			"sexe_tag"=>$sexe, 
			"idville_tag"=>$idVille
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
	// Méthode static qui modifie un Demandeur
	public static function updateDemandeur($idDeman, $login, $mdp, $nom, $prenom, $dateNais,
    $adresse, $tel, $sexe, $idVille){
		$requetePreparee = "UPDATE Demandeur SET login = :login_tag, motDePasse = :mdp_tag, nom = :nom_tag, prenom = :prenom_tag, 
        dateNaissance = :dateNais_tag, adresse = :adresse_tag, telephone = :tel_tag, sexe = :sexe_tag, id_ville = :idville_tag 
        WHERE idDemandeur = :idDeman_tag ;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array(
			"idDeman_tag"=>$idDeman_tag, 
			"login_tag"=>$login, 
			"mdp_tag"=>$mdp, 
			"nom_tag"=>$nom, 
			"prenom_tag"=>$prenom, 
			"dateNais_tag"=>$dateNais, 
			"adresse_tag"=>$adresse, 
			"tel_tag"=>$tel, 
			"sexe_tag"=>$sexe, 
			"idville_tag"=>$idVille
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
	// Méthode static qui supprime un Demandeur
	public static function deleteDemandeur($idDemandeur){
		$requetePreparee = "DELETE FROM Demandeur WHERE idDemandeur = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("id_tag" => $idDemandeur);
		try{
			$req_prep->execute($valeurs);
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne un Demandeur identifié par son idDemandeur
	public static function getDemandeurById($idDemandeur) {
		// écriture de la requête
		$requetePreparee = "SELECT * FROM Demandeur WHERE idDemandeur = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		// le tableau des valeurs
		$valeurs = array("id_tag" => $idDemandeur);
		try {
			// envoi de la requête
			$req_prep->execute($valeurs);
			// traitement de la réponse
		$req_prep->setFetchmode(PDO::FETCH_CLASS,'Demandeur');
			// récupération du demandeur
			$a = $req_prep->fetch();
			// retour
			return $a;
		} catch(PDEException $e) {
			echo $e->getMessage();
		}
	}

	
	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne les Demandeurs en un tableau d'objets
	public static function getAllDemandeurs() {
		// écriture de la requête
		$requete = "SELECT * FROM Demandeur;";
	// envoi de la requête et stockage de la réponse
		$resultat = Connexion::pdo()->query($requete);
	// traitement de la réponse
	$resultat->setFetchmode(PDO::FETCH_CLASS,'Demandeur');
	$tableau = $resultat->fetchAll();
		return $tableau;
	}
}
?>