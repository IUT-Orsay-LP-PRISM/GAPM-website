<?php

namespace App\models\entity;

class Administrateur{

	private $idAdministrateur;
	private $login;
	private $nom;
	private $prenom;
	private $motDePasse;

    /**
     * @param array|null $data Constructeur qui prend un tableau en paramètres, ça sera toutes les propriétés cités ci-dessus
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
     * @return mixed
     */
    public function getIdAdministrateur()
    {
        return $this->idAdministrateur;
    }

    /**
     * @param mixed $idAdministrateur
     */
    public function setIdAdministrateur($idAdministrateur)
    {
        $this->idAdministrateur = $idAdministrateur;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    /**
     * @param mixed $motDePasse
     */
    public function setMotDePasse($motDePasse)
    {
        $this->motDePasse = $motDePasse;
    }


}
?>