<?php

namespace App\models\entity;

class Voiture
{


    private $idVoiture;
    private $immatriculation;
    private $idTypeVoiture;

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
    public function getIdVoiture()
    {
        return $this->idVoiture;
    }

    /**
     * @return mixed
     */
    public function getImmatriculation()
    {
        return $this->immatriculation;
    }

    /**
     * @return mixed
     */
    public function getIdTypeVoiture()
    {
        return $this->idTypeVoiture;
    }


    // -------------------------------------------------------------------------------------------
    // Setters

    /**
     * @param mixed $idVoiture
     */
    public function setIdVoiture($idVoiture): void
    {
        $this->idVoiture = $idVoiture;
    }

    /**
     * @param mixed $immatriculation
     */
    public function setImmatriculation($immatriculation): void
    {
        $this->immatriculation = $immatriculation;
    }

    /**
     * @param mixed $idTypeVoiture
     */
    public function setIdTypeVoiture($idTypeVoiture): void
    {
        $this->idTypeVoiture = $idTypeVoiture;
    }
}
