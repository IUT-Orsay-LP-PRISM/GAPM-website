<?php

namespace App\models\entity;

class Personnel
{

    private $login;
    private $nom;
    private $prenom;
    private $motDePasse;
    private $email;


    // -------------------------------------------------------------------------------------------
    // Constructeur

    /**
     * @param array|null $data
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
    // Getters

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @return mixed
     */
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    // -------------------------------------------------------------------------------------------
    // Setters


    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @param mixed $motDePasse
     */
    public function setMotDePasse($motDePasse): void
    {
        $this->motDePasse = $motDePasse;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }
}