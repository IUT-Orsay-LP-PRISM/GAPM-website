<?php

namespace App\models\entity;

use App\models\repository\VilleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
#[ORM\Table(name: 'Ville')]
class Ville
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private $idVille;
    #[ORM\Column]
    private $nom;
    #[ORM\Column]
    private $codePostal;

    /**
     * @return mixed
     */
    public function getIdVille(): mixed
    {
        return $this->idVille;
    }

    /**
     * @param mixed $idVille
     */
    public function setIdVille(mixed $idVille)
    {
        $this->idVille = $idVille;
    }

    /**
     * @return mixed
     */
    public function getNom(): mixed
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getCodePostal(): mixed
    {
        return $this->codePostal;
    }

    /**
     * @param mixed $codePostal
     */
    public function setCodePostal($codePostal): void
    {
        $this->codePostal = $codePostal;
    }
}


