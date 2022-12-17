<?php

namespace App\models\entity;

class Emprunt
{

    private $idEmprunt;
    private $dateDebut;
    private $dateFin;
    private $idIntervenant;
    private $login;
    private $idVoiture;

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
    public function getIdEmprunt()
    {
        return $this->idEmprunt;
    }

    /**
     * @return mixed
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @return mixed
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @return mixed
     */
    public function getIdIntervenant()
    {
        return $this->idIntervenant;
    }

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
    public function getIdVoiture()
    {
        return $this->idVoiture;
    }



    // -------------------------------------------------------------------------------------------
    // Setters


    /**
     * @param mixed $idEmprunt
     */
    public function setIdEmprunt($idEmprunt): void
    {
        $this->idEmprunt = $idEmprunt;
    }

    /**
     * @param mixed $dateDebut
     */
    public function setDateDebut($dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @param mixed $dateFin
     */
    public function setDateFin($dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @param mixed $idIntervenant
     */
    public function setIdIntervenant($idIntervenant): void
    {
        $this->idIntervenant = $idIntervenant;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }

    /**
     * @param mixed $idVoiture
     */
    public function setIdVoiture($idVoiture): void
    {
        $this->idVoiture = $idVoiture;
    }

}
