<?php

namespace App\models\entity;

class Ville
{
    private $idVille;
    private $nom;
    private $codePostal;
    private $codeDepartement;

    // -------------------------------------------------------------------------------------------
    // Constructeur
    function __construct(array $data = null)
    {
        if ($data != null) {
            foreach ($data as $key => $element) {
                $this->$key = $element;
            }
        }
    }


    // -------------------------------------------------------------------------------------------
    // Getters & Setters
    /**
     * @return mixed
     */
    public function getIdVille()
    {
        return $this->idVille;
    }

    /**
     * @param mixed $idVille
     */
    public function setIdVille($idVille)
    {
        $this->idVille = $idVille;
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
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param mixed $codePostal
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
    }

    /**
     * @return mixed
     */
    public function getCodeDepartement()
    {
        return $this->codeDepartement;
    }

    /**
     * @param mixed $codeDepartement
     */
    public function setCodeDepartement($codeDepartement)
    {
        $this->codeDepartement = $codeDepartement;
    }
}
