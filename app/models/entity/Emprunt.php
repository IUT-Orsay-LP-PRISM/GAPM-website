<?php

namespace App\models\entity;

use App\models\Repository\EmpruntRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
#[ORM\Table(name: 'Emprunt')]
class Emprunt
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $idEmprunt;
    #[ORM\Column]
    private string $dateDebut;

    #[ORM\Column]
    private string $dateFin;

    #[ORM\ManyToOne(targetEntity: Intervenant::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'idIntervenant', referencedColumnName: 'idDemandeur', nullable: false)]
    private Intervenant $intervenant;

    #[ORM\ManyToOne(targetEntity: Administration::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'idAdministration', referencedColumnName: 'idAdministration', nullable: true)]
    private Administration $administration;

    #[ORM\ManyToOne(targetEntity: Voiture::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'idVoiture', referencedColumnName: 'idVoiture', nullable: false)]
    private Voiture $voiture;

    public function __construct()
    {

    }

    /**
     * @return int
     */
    public function getIdEmprunt(): int
    {
        return $this->idEmprunt;
    }

    /**
     * @param int $idEmprunt
     */
    public function setIdEmprunt(int $idEmprunt): void
    {
        $this->idEmprunt = $idEmprunt;
    }

    /**
     * @return string
     */
    public function getDateDebut(): string
    {
        return $this->dateDebut;
    }

    /**
     * @param string $dateDebut
     */
    public function setDateDebut(string $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return string
     */
    public function getDateFin(): string
    {
        return $this->dateFin;
    }

    /**
     * @param string $dateFin
     */
    public function setDateFin(string $dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return Intervenant
     */
    public function getIntervenant(): Intervenant
    {
        return $this->intervenant;
    }

    /**
     * @param Intervenant $intervenant
     */
    public function setIntervenant(Intervenant $intervenant): void
    {
        $this->intervenant = $intervenant;
    }

    /**
     * @return Administration
     */
    public function getAdministration(): Administration
    {
        return $this->administration;
    }

    /**
     * @param Administration $administration
     */
    public function setAdministration(Administration $administration): void
    {
        $this->administration = $administration;
    }

    /**
     * @return Voiture
     */
    public function getVoiture(): Voiture
    {
        return $this->voiture;
    }

    /**
     * @param Voiture $voiture
     */
    public function setVoiture(Voiture $voiture): void
    {
        $this->voiture = $voiture;
    }


}