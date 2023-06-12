<?php

namespace App\models\entity;
use App\models\repository\EmpechementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpechementRepository::class)]
#[ORM\Table(name: 'Empechement')]
class Empechement
{

    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $idEmpechement;

    #[ORM\Column]
    private string $dateDebut;

    #[ORM\Column]
    private string $dateFin;

    #[ORM\Column]
    private string $heureDebut;

    #[ORM\Column]
    private string $heureFin;

    #[ORM\ManyToOne(targetEntity: Intervenant::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'idIntervenant', referencedColumnName: 'idDemandeur', nullable: false)]
    private Intervenant $intervenant;


    /**
     * @return int
     */
    public function getIdEmpechement(): int
    {
        return $this->idEmpechement;
    }

    /**
     * @param int $idEmpechement
     */
    public function setIdEmpechement(int $idEmpechement): void
    {
        $this->idEmpechement = $idEmpechement;
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
     * @return string
     */
    public function getHeureDebut(): string
    {
        return $this->heureDebut;
    }

    /**
     * @param string $heureDebut
     */
    public function setHeureDebut(string $heureDebut): void
    {
        $this->heureDebut = $heureDebut;
    }

    /**
     * @return string
     */
    public function getHeureFin(): string
    {
        return $this->heureFin;
    }

    /**
     * @param string $heureFin
     */
    public function setHeureFin(string $heureFin): void
    {
        $this->heureFin = $heureFin;
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
}