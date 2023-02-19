<?php

namespace App\models\entity;

class Service{

	private $id_Service;

    private $libelle;
	private $description;

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
     * @return mixed - Getteur id service
     */
	public function getIdService(){return $this->id_Service;}

    /**
     * @return mixed - Getteur description
     */
	public function getDescription(){return $this->description;}

    /**
     * @return mixed - Getteur libelle
     */
    public function getLibelle(){return $this->libelle;}

    // -------------------------------------------------------------------------------------------
    // Setters

    /**
     * @param mixed $idService
     */
    public function setIdService($idService): void
    {
        $this->idService = $idService;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $libelle
     */
    public function setLibelle($libelle): void
    {
        $this->libelle = $libelle;
    }







}
?>