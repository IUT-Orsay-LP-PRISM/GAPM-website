<?php

namespace App\models\entity;

use App\models\repository\SpecialiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialiteRepository::class)]
#[ORM\Table(name: 'Specialite')]
class Specialite
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $idSpecialite;
    #[ORM\Column]
    private string $libelle;
    #[ORM\Column]
    private string $description;

    public function __construct()
    {

    }

    /**
     * @return int
     */
    public function getIdSpecialite(): int
    {
        return $this->idSpecialite;
    }

    /**
     * @param int $idSpecialite
     */
    public function setIdSpecialite(int $idSpecialite): void
    {
        $this->idSpecialite = $idSpecialite;
    }

    /**
     * @return string
     */
    public function getLibelle(): string
    {
        return $this->libelle;
    }

    /**
     * @param string $libelle
     */
    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }


}