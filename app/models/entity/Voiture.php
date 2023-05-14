<?php

namespace App\models\entity;

use App\models\Repository\VoitureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
#[ORM\Table(name: 'Voiture')]
class Voiture
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $idVoiture;
    #[ORM\Column]
    private string $immatriculation;

    #[ORM\ManyToOne(targetEntity: TypeVoiture::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'idTypeVoiture', referencedColumnName: 'idTypeVoiture', nullable: false)]
    private TypeVoiture $typeVoiture;

    public function __construct()
    {

    }

    /**
     * @return int
     */
    public function getIdVoiture(): int
    {
        return $this->idVoiture;
    }

    /**
     * @param int $idVoiture
     */
    public function setIdVoiture(int $idVoiture): void
    {
        $this->idVoiture = $idVoiture;
    }

    /**
     * @return string
     */
    public function getImmatriculation(): string
    {
        return $this->immatriculation;
    }

    /**
     * @param string $immatriculation
     */
    public function setImmatriculation(string $immatriculation): void
    {
        $this->immatriculation = $immatriculation;
    }

    /**
     * @return Ville
     */
    public function getTypeVoiture(): TypeVoiture
    {
        return $this->typeVoiture;
    }

    /**
     * @param Ville $typeVoiture
     */
    public function setTypeVoiture(Ville $typeVoiture): void
    {
        $this->typeVoiture = $typeVoiture;
    }


}