<?php

namespace App\models\entity;

class FichePaie
{
    private $idFichePaie;
    private $url;
    private $idIntervenant;
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
    public function getIdFichePaie()
    {
        return $this->idFichePaie;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
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



    // -------------------------------------------------------------------------------------------
    // Setters


    /**
     * @param mixed $idFichePaie
     */
    public function setIdFichePaie($idFichePaie): void
    {
        $this->idFichePaie = $idFichePaie;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
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

}