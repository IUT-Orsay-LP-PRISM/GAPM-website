<?php

namespace App\models\entity;

use App\models\repository\TypeVoitureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeVoitureRepository::class)]
#[ORM\Table(name: 'TypeVoiture')]
class TypeVoiture
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $idTypeVoiture;

    #[ORM\Column]
    private string $marque;
    #[ORM\Column]
    private string $modele;

    public function __construct()
    {

    }

    /**
     * @return int
     */
    public function getIdTypeVoiture(): int
    {
        return $this->idTypeVoiture;
    }

    /**
     * @param int $idTypeVoiture
     */
    public function setIdTypeVoiture(int $idTypeVoiture): void
    {
        $this->idTypeVoiture = $idTypeVoiture;
    }

    /**
     * @return string
     */
    public function getModele(): string
    {
        return $this->modele;
    }

    /**
     * @param string $modele
     */
    public function setModele(string $modele): void
    {
        $this->modele = $modele;
    }

    /**
     * @return string
     */
    public function getMarque(): string
    {
        return $this->marque;
    }

    /**
     * @param string $marque
     */
    public function setMarque(string $marque): void
    {
        $this->marque = $marque;
    }

}