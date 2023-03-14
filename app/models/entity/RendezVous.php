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

    #[ORM\OneToOne(targetEntity: Demandeur::class, fetch: 'LAZY')]
    #[ORM\JoinColumn(name: 'idDemandeur', referencedColumnName: 'idDemandeur', nullable: false)]
    private Demandeur $demandeur;

    #[ORM\OneToOne(targetEntity: Intervenant::class, fetch: 'LAZY')]
    #[ORM\JoinColumn(name: 'idIntervenant', referencedColumnName: 'idDemandeur', nullable: false)]
    private Intervenant $intervenant;

    #[ORM\ManyToOne(targetEntity: Specialite::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'idSpecialite', referencedColumnName: 'idSpecialite', nullable: false)]
    private Specialite $specialite;

    #[ORM\OneToOne(targetEntity: Commentaire::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'idCommentaire', referencedColumnName: 'idCommentaire', nullable: false)]
    private Commentaire $commentaire;


    public function setCommentaire(Commentaire $commentaire): void{
        $this->commentaire = $commentaire;
    }

    public function getCommentaire(): Commentaire{
        return $this->commentaire;
    }

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
        // todo check si un rendez-vous est déjà pris à cette date et à cette heure

    }

    /**
     * @return Specialite
     */
    public function getSpecialite(): Specialite
    {
        return $this->specialite;
    }

    /**
     * @param Specialite $specialite
     */
    public function setSpecialite(Specialite $specialite): void
    {
        $this->specialite = $specialite;
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