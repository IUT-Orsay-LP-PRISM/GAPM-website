<?php

namespace App\models\entity;

class Commentaire
{

    private $idCommentaire;
    private $description;
    private $note;
    private $idRdv;
    private $idDemandeur;

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

    public function getIdCommentaire()
    {
        return $this->idCommentaire;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function getIdRdv()
    {
        return $this->idRdv;
    }

    public function getIdDemandeur()
    {
        return $this->idDemandeur;
    }


    // -------------------------------------------------------------------------------------------
    // Setters
    /**
     * @param mixed $idCommentaire
     */
    public function setIdCommentaire($idCommentaire): void
    {
        $this->idCommentaire = $idCommentaire;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note): void
    {
        $this->note = $note;
    }

    /**
     * @param mixed $idRdv
     */
    public function setIdRdv($idRdv): void
    {
        $this->idRdv = $idRdv;
    }

    /**
     * @param mixed $idDemandeur
     */
    public function setIdDemandeur($idDemandeur): void
    {
        $this->idDemandeur = $idDemandeur;
    }
}




