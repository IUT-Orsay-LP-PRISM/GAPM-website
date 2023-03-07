<?php

namespace App\models\entity;

use App\models\repository\IntervenantRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IntervenantRepository::class)]
#[ORM\Table(name: 'Intervenant')]
class Intervenant extends Demandeur
{
    #[ORM\Column]
    private string $adressePro;
    #[ORM\JoinTable(name: 'Intervenant_Specialite')]
    #[ORM\JoinColumn(name: 'idIntervenant', referencedColumnName: 'idDemandeur', nullable: false)]
    #[ORM\InverseJoinColumn(name: 'idSpecialite', referencedColumnName: 'idSpecialite', nullable: false)]
    #[ORM\ManyToMany(targetEntity: Specialite::class, fetch: 'EAGER')]
    private $specialites;

    public function __construct()
    {
        $this->specialites = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdIntervenant(): int
    {
        return $this->idIntervenant;
    }

    /**
     * @param int $idIntervenant
     */
    public function setIdIntervenant(int $idIntervenant): void
    {
        $this->idIntervenant = $idIntervenant;
    }

    /**
     * @return string
     */
    public function getAdressePro(): string
    {
        return $this->adressePro;
    }

    /**
     * @param string $adressePro
     */
    public function setAdressePro(string $adressePro): void
    {
        $this->adressePro = $adressePro;
    }

    /**
     * @return Collection
     */
    public function getSpecialites(): Collection
    {
        return $this->specialites;
    }

    /**
     * @param Collection $specialites
     */
    public function setSpecialites(Collection $specialites): void
    {
        $this->specialites = $specialites;
    }

}
