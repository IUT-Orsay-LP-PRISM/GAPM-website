<?php

namespace App\models\dao;

use PDO;

class IntervenantDao extends ConnexionDB{

	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// Méthodes

	// Méthode static qui affiche un Intervenant
    public function display() {
        echo "<p>Intervenant 
            <ul>
                <li>idIntervenant : $this->idIntervenant</li> 
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
                <li>adressePro : $this->adressePro</li>
            </ul>
        </p>";
    }


	// -------------------------------------------------------------------------------------------
	// Méthode static qui insère un Intervenant
    public static function insertIntervenant($login, $mdp, $nom, $prenom, $dateNais,
    $adresse, $tel, $sexe, $idVille, $adressePro){
        // -------------------------------------------------------------------
        // Insertion côté demandeur

        if(self::insertDemandeur($login, $mdp, $nom, $prenom, $dateNais,
        $adresse, $tel, $sexe, $idVille)){
            if($objetDemandeur = self::getDemandeurByLogin($login)){

                // -------------------------------------------------------------------
                // Insertion côté intervenant
                $requetePrepareeIntervenant = "INSERT INTO Intervenant (adressePro, id_demandeur) 
                                    VALUES (:adressePro_tag, :idDeman_tag) ;";
                $req_prepIntervenant = Connexion::pdo()->prepare($requetePrepareeIntervenant);
                $valeursIntervenant = array(
                    "adressePro_tag"=>$adressePro, 
                    "idDeman_tag"=>$objetDemandeur->get("idIntervenant")
                );

                try{
                    $req_prepIntervenant->execute($valeursIntervenant);
                  return true;
                } catch(PDOException $e){
                      echo $e;
                    die();
                      return false;
                }
            }
        }
    }
	

	// -------------------------------------------------------------------------------------------
	// Méthode static qui modifie un Intervenant
    public static function updateIntervenant($idIntervenant, $login, $mdp, $nom, $prenom, $dateNais,
    $adresse, $tel, $sexe, $idVille, $adressePro){

        // On recupére l'intervenant pour accèder à son idDemandeur
        $objetIntervenant = self::getIntervenantById($idIntervenant);

        if($objetIntervenant!=NULL){
            // -------------------------------------------------------------------
            // Update côté demandeur
            if (self::updateDemandeur($objetIntervenant->get("idDemandeur"), $login, $mdp, $nom, 
            $prenom, $dateNais, $adresse, $tel, $sexe, $idVille)){

                // -------------------------------------------------------------------
                // Update côté intervenant
                $requetePreparee = "UPDATE Intervenant SET adressePro = :adressePro_tag, id_demandeur = :idDeman_tag
                WHERE idIntervenant = :idInt_tag ;";
                $req_prep = Connexion::pdo()->prepare($requetePreparee);
                $valeurs = array(
                    "idInt_tag"=>$idIntervenant, 
                    "adressePro_tag"=>$adressePro, 
                    "idDeman_tag"=>$idDemandeur
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
        }else{
            return false;
        }
    }


	// -------------------------------------------------------------------------------------------
	// Méthode static qui supprime un Intervenant
	public static function deleteIntervenant($idIntervenant){
		$requetePreparee = "DELETE FROM Intervenant WHERE idIntervenant = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		$valeurs = array("id_tag" => $idIntervenant);
		try{
			$req_prep->execute($valeurs);
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne un Intervenant identifié par son idIntervenant
	public static function getIntervenantById($idIntervenant) {
		// écriture de la requête
		$requetePreparee = "SELECT * FROM Intervenant WHERE idIntervenant = :id_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		// le tableau des valeurs
		$valeurs = array("id_tag" => $idIntervenant);
		try {
			// envoi de la requête
			$req_prep->execute($valeurs);
			// traitement de la réponse
		$req_prep->setFetchmode(PDO::FETCH_CLASS,'App\models\entity\Intervenant');
			// récupération de l'intervenant
			$a = $req_prep->fetch();
			// retour
			return $a;
		} catch(PDEException $e) {
			echo $e->getMessage();
		}
	}


	// -------------------------------------------------------------------------------------------
	// Méthode static qui retourne les Intervenants en un tableau d'objets
	public static function getAllIntervenants() {
		// écriture de la requête
		$requete = "SELECT * FROM Intervenant;";
	// envoi de la requête et stockage de la réponse
		$resultat = Connexion::pdo()->query($requete);
	// traitement de la réponse
	$resultat->setFetchmode(PDO::FETCH_CLASS,'App\models\entity\Intervenant');
	$tableau = $resultat->fetchAll();
		return $tableau;
	}
}
?>