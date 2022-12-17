<?php

namespace App\models\entity;

class NoteFrais
{

    private $idNoteFrais;
    private $dateNote;
    private $description;
    private $urlJustificatif;
    private $montant;
    private $status;
    private $login;


    // -------------------------------------------------------------------------------------------
    // Constructeur
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
    public function getIdNoteFrais()
    {
        return $this->idNoteFrais;
    }

    /**
     * @return mixed
     */
    public function getDateNote()
    {
        return $this->dateNote;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getUrlJustificatif()
    {
        return $this->urlJustificatif;
    }

    /**
     * @return mixed
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }


    // -------------------------------------------------------------------------------------------
    // Setters

    /**
     * @param mixed $idNoteFrais
     */
    public function setIdNoteFrais($idNoteFrais): void
    {
        $this->idNoteFrais = $idNoteFrais;
    }

    /**
     * @param mixed $dateNote
     */
    public function setDateNote($dateNote): void
    {
        $this->dateNote = $dateNote;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $urlJustificatif
     */
    public function setUrlJustificatif($urlJustificatif): void
    {
        $this->urlJustificatif = $urlJustificatif;
    }

    /**
     * @param mixed $montant
     */
    public function setMontant($montant): void
    {
        $this->montant = $montant;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }





}

?>