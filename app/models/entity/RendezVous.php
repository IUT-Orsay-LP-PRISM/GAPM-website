<?php

namespace App\models\entity;

class RendezVous
{

    private $idRdv;
    private $status;
    private $dateRdv;
    private $heureDebut;
    private $heureFin;
    private $id_Demandeur;
    private $id_Service;
    private $id_Intervenant;


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

    public function getId_Demandeur()
    {
        return $this->id_Demandeur;
    }

    public function getId_Service()
    {
        return $this->id_Service;
    }

    public function getId_Intervenant()
    {
        return $this->id_Intervenant;
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
    public function setId_Demandeur($idDemandeur): void
    {
        $this->id_Demandeur = $idDemandeur;
    }

    /**
     * @param mixed $idService
     */
    public function setId_Service($idService): void
    {
        $this->id_Service = $idService;
    }

    /**
     * @param mixed $idIntervenant
     */
    public function setId_Intervenant($idIntervenant): void
    {
        $this->id_Intervenant = $idIntervenant;
    }

}