<?php

namespace App\models\entity;

class Demandeur
{

    private $idDemandeur;
    private $login;
    private $motDePasse;
    private $nom;
    private $prenom;
    private $dateNaissance;
    private $adresse;
    private $telephone;
    private $sexe;

    // -------------------------------------------------------------------------------------------
    // Constructeur
    /**
     * @param int $idDemandeur Id du demandeur
     * @param String $login Login permettant de l'identifier
     * @param String $motDePasse Son MDP chiffré
     * @param String $nom Son nom
     * @param String $prenom Son prenom
     * @param array|null $data Le reste des données formatées en tableau pour l'insertion de données facultatives
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            foreach ($data as $key => $element) {
                $this->$key = $element;
            }
        }
    }

    // -------------------------------------------------------------------------------------------
    // getters & setters
    /**
     * @return int
     */
    public function getIdDemandeur()
    {
        return $this->idDemandeur;
    }

    /**
     * @param int $idDemandeur
     */
    public function setIdDemandeur(int $idDemandeur)
    {
        $this->idDemandeur = $idDemandeur;
    }

    /**
     * @return String
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param String $login
     */
    public function setLogin(string $login)
    {
        $this->login = $login;
    }

    /**
     * @return String
     */
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    /**
     * @param String $motDePasse
     */
    public function setMotDePasse(string $motDePasse)
    {
        $this->motDePasse = $motDePasse;
    }

    /**
     * @return String
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param String $nom
     */
    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return String
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param String $prenom
     */
    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return String
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @param String $dateNaissance
     */
    public function setDateNaissance(string $dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
    }

    /**
     * @return String
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param String $adresse
     */
    public function setAdresse(string $adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return String
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param String $telephone
     */
    public function setTelephone(string $telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return String
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param String $sexe
     */
    public function setSexe(string $sexe)
    {
        $this->sexe = $sexe;
    }

}
