<?php

namespace App\models\entity;

class Demandeur
{

    private int $id_Demandeur;
    private string $login;
    private string $email;
    private string $motDePasse;
    private string $nom;
    private string $prenom;
    private string $dateNaissance;
    private string $adresse;
    private string $telephone;
    private string $sexe;
    private int $id_Ville;

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
        return $this->id_Demandeur;
    }

    /**
     * @param int $id_Demandeur
     */
    public function setIdDemandeur(int $id_Demandeur)
    {
        $this->id_Demandeur = $id_Demandeur;
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

    /**
     * @return int
     */
    public function getId_Ville()
    {
        return $this->id_Ville;
    }

    /**
     * @param int $id_Ville
     */
    public function setIdVille(int $id_Ville)
    {
        $this->id_Ville = $id_Ville;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

}
