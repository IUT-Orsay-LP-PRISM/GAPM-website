<?php

namespace App\models\entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'Commentaire')]
class Commentaire
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $idCommentaire;

    #[ORM\Column]
    private string $description;

    #[ORM\Column(type: 'float', nullable: false)]
    private float $note;

    #[ORM\ManyToOne(targetEntity: Demandeur::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(name: 'idDemandeur', referencedColumnName: 'idDemandeur', nullable: false)]
    private Demandeur $demandeur;

    #[ORM\OneToOne(targetEntity: RendezVous::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'idRdv', referencedColumnName: 'idRdv', nullable: false)]
    private RendezVous $rendezVous;


    /**
     * @return int
     */
    public function getIdCommentaire(): int
    {
        return $this->idCommentaire;
    }

    /**
     * @param int $idCommentaire
     */
    public function setIdCommentaire(int $idCommentaire): void
    {
        $this->idCommentaire = $idCommentaire;
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

    /**
     * @return float
     */
    public function getNote(): float
    {
        return $this->note;
    }

    /**
     * @param float $note
     */
    public function setNote(float $note): void
    {
        $this->note = $note;
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

    /**
     * @return RendezVous
     */
    public function getRendezVous(): RendezVous
    {
        return $this->rendezVous;
    }

    /**
     * @param RendezVous $rendezVous
     */
    public function setRendezVous(RendezVous $rendezVous): void
    {
        $this->rendezVous = $rendezVous;
    }

}