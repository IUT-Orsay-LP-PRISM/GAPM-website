<?php

namespace App\models\entity;

class Empechement
{

    private $idEmpechement;
    private $dateDebut;
    private $dateFin;
    private $idIntervenant;

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
    public function getIdEmpechement()
    {
        return $this->idEmpechement;
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


    // -------------------------------------------------------------------------------------------
    // Setters


    /**
     * @param mixed $idEmpechement
     */
    public function setIdEmpechement($idEmpechement): void
    {
        $this->idEmpechement = $idEmpechement;
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

}
