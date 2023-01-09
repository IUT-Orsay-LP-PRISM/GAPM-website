<?php

namespace App\models\entity;

class RendezVous
{

    private $idRdv;
    private $status;
    private $dateRdv;
    private $heureDebut;
    private $heureFin;
    private $idDemandeur;
    private $idService;
    private $idIntervenant;


    // -------------------------------------------------------------------------------------------
    // Constructeur
    function __construct($data = null)
    {
        if ($data != null) {
            foreach ($data as $key => $element) {
                $this->$key = $element;
            }
        }
    }


    // -------------------------------------------------------------------------------------------
    // Getters

    public function getIdRdv()
    {
        return $this->idRdv;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getDateRdv()
    {
        return $this->dateRdv;
    }

    public function getHeureDebut()
    {
        return $this->heureDebut;
    }

    public function getHeureFin()
    {
        return $this->heureFin;
    }

    public function getIdDemandeur()
    {
        return $this->idDemandeur;
    }

    public function getIdService()
    {
        return $this->idService;
    }

    public function getIdIntervenant()
    {
        return $this->idIntervenant;
    }



    // -------------------------------------------------------------------------------------------
    // Setters
    /**
     * @param mixed $idRdv
     */
    public function setIdRdv($idRdv): void
    {
        $this->idRdv = $idRdv;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @param mixed $dateRdv
     */
    public function setDateRdv($dateRdv): void
    {
        $this->dateRdv = $dateRdv;
    }

    /**
     * @param mixed $heureDebut
     */
    public function setHeureDebut($heureDebut): void
    {
        $this->heureDebut = $heureDebut;
    }

    /**
     * @param mixed $heureFin
     */
    public function setHeureFin($heureFin): void
    {
        $this->heureFin = $heureFin;
    }

    /**
     * @param mixed $idDemandeur
     */
    public function setIdDemandeur($idDemandeur): void
    {
        $this->idDemandeur = $idDemandeur;
    }

    /**
     * @param mixed $idService
     */
    public function setIdService($idService): void
    {
        $this->idService = $idService;
    }

    /**
     * @param mixed $idIntervenant
     */
    public function setIdIntervenant($idIntervenant): void
    {
        $this->idIntervenant = $idIntervenant;
    }

}