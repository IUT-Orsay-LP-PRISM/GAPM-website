<?php

namespace App\models\entity;

class Intervenant extends Demandeur
{

    private $id_Intervenant;
    private $adressePro;

    private $specialites;

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
    public function getId_Intervenant()
    {
        return $this->id_Intervenant;
    }

    /**
     * @param mixed $id_Intervenant
     */
    public function setId_Intervenant($idIntervenant)
    {
        $this->id_Intervenant = $idIntervenant;
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

    /**
     * @return mixed
     */
    public function getSpecialites()
    {
        return $this->specialites;
    }

    /**
     * @param mixed $specialites
     */

    public function setSpecialites($specialites)
    {
        $this->specialites = $specialites;
    }


}
