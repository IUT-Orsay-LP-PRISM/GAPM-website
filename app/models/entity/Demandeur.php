<?php

namespace App\models\entity;

class Demandeur
{

    private int $idDemandeur;
    private string $login;
    private string $motDePasse;
    private string $nom;
    private string $prenom;
    private string $dateNaissance;
    private string $adresse;
    private string $telephone;
    private string $sexe;

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

    /**
     * @return int
     */
    public function getIdDemandeur(): int
    {
        return $this->idDemandeur;
    }

    /**
     * @param int $idDemandeur
     */
    public function setIdDemandeur(int $idDemandeur): void
    {
        $this->idDemandeur = $idDemandeur;
    }

    /**
     * @return String
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param String $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return String
     */
    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }

    /**
     * @param String $motDePasse
     */
    public function setMotDePasse(string $motDePasse): void
    {
        $this->motDePasse = $motDePasse;
    }

    /**
     * @return String
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param String $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return String
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param String $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return String
     */
    public function getDateNaissance(): string
    {
        return $this->dateNaissance;
    }

    /**
     * @param String $dateNaissance
     */
    public function setDateNaissance(string $dateNaissance): void
    {
        $this->dateNaissance = $dateNaissance;
    }

    /**
     * @return String
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * @param String $adresse
     */
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * @return String
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * @param String $telephone
     */
    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return String
     */
    public function getSexe(): string
    {
        return $this->sexe;
    }

    /**
     * @param String $sexe
     */
    public function setSexe(string $sexe): void
    {
        $this->sexe = $sexe;
    }

}
