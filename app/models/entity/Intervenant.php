<?php

namespace App\models\entity;

class Intervenant extends Demandeur{

    private $idIntervenant;
    private $adressePro;

    // -------------------------------------------------------------------------------------------
    // Constructeur

    /**
     * @param array|null $data Constructeur qui prend un tableau en paramètres, ça sera toutes les propriétés cités ci-dessus en + du demandeur
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
        if ($data != null) {
            foreach ($data as $key => $element) {
                $this->$key = $element;
            }
        }
    }

    // -------------------------------------------------------------------------------------------
    // getters & setters
    /**
     * @return mixed
     */
    public function getIdIntervenant()
    {
        return $this->idIntervenant;
    }

    /**
     * @param mixed $idIntervenant
     */
    public function setIdIntervenant($idIntervenant)
    {
        $this->idIntervenant = $idIntervenant;
    }

    /**
     * @return mixed
     */
    public function getAdressePro()
    {
        return $this->adressePro;
    }

    /**
     * @param mixed $adressePro
     */
    public function setAdressePro($adressePro)
    {
        $this->adressePro = $adressePro;
    }


}
