<?php

namespace App\models\entity;

class TypeVoiture
{

    private $idTypeVoiture;
    private $modele;

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
    public function getIdTypeVoiture()
    {
        return $this->idTypeVoiture;
    }

    /**
     * @return mixed
     */
    public function getModele()
    {
        return $this->modele;
    }


    // -------------------------------------------------------------------------------------------
    // Setters

    /**
     * @param mixed $idTypeVoiture
     */
    public function setIdTypeVoiture($idTypeVoiture): void
    {
        $this->idTypeVoiture = $idTypeVoiture;
    }

    /**
     * @param mixed $modele
     */
    public function setModele($modele): void
    {
        $this->modele = $modele;
    }


}

?>