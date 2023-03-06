<?php

namespace App\models\entity;

use App\models\repository\RendezVousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
#[ORM\Table(name: 'RDV')]
class RendezVous
{

    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $idRdv;
    #[ORM\Column]
    private string $status;
    #[ORM\Column]
    private string $dateRdv;
    #[ORM\Column]
    private string $heureDebut;
    #[ORM\Column]
    private string $heureFin;
    #[ORM\OneToOne(targetEntity: Demandeur::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'idDemandeur', referencedColumnName: 'idDemandeur', nullable: false)]
    private Demandeur $demandeur;



    /**
     * @return int
     */
    public function getIdRdv(): int
    {
        return $this->idRdv;
    }

    /**
     * @param int $idRdv
     */
    public function setIdRdv(int $idRdv): void
    {
        $this->idRdv = $idRdv;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getDateRdv(): string
    {
        return $this->dateRdv;
    }

    /**
     * @param string $dateRdv
     */
    public function setDateRdv(string $dateRdv): void
    {
        $this->dateRdv = $dateRdv;
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
     * @return Demandeur
     */
    public function getDemandeur(): Demandeur
    {
        return $this->demandeur;
    }

    /**
     * @param Demandeur $demandeur
     */
    public function setDemandeur(Demandeur $demandeur): void
    {
        $this->demandeur = $demandeur;
    }

    public function contains(Rendezvous $rendezvous)
    {
        // check if the given $rendezvous is in the current $rendezvous
        // return true or false

    }


}