<?php

namespace App\models\entity;

use App\models\repository\DepenseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepenseRepository::class)]
#[ORM\Table(name: 'Depense')]
class Depense
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $idDepense;

    #[ORM\Column]
    private string $nature;

    #[ORM\Column]
    private string $datePaiement;

    #[ORM\Column]
    private string $montant;

    #[ORM\Column]
    private string $fournisseur;

    #[ORM\Column]
    private string $commentaire;

    #[ORM\Column]
    private string $status;

    #[ORM\Column]
    private string $dateCreation;

    #[ORM\Column]
    private string|null $urlJustificatif;

    #[ORM\ManyToOne(targetEntity: Intervenant::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'idIntervenant', referencedColumnName: 'idDemandeur', nullable: false)]
    private Intervenant $intervenant;

    #[ORM\ManyToOne(targetEntity: NoteFrais::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'idNoteFrais', referencedColumnName: 'idNoteFrais', nullable: true)]
    private ?NoteFrais $noteFrais = null;

    /**
     * @return int
     */
    public function getIdDepense(): int
    {
        return $this->idDepense;
    }

    /**
     * @param int $idDepense
     */
    public function setIdDepense(int $idDepense): void
    {
        $this->idDepense = $idDepense;
    }

    /**
     * @return string
     */
    public function getNature(): string
    {
        return $this->nature;
    }

    /**
     * @param string $nature
     */
    public function setNature(string $nature): void
    {
        $this->nature = $nature;
    }

    /**
     * @return string
     */
    public function getDatePaiement(): string
    {
        return $this->datePaiement;
    }

    /**
     * @param string $datePaiement
     */
    public function setDatePaiement(string $datePaiement): void
    {
        $this->datePaiement = $datePaiement;
    }

    /**
     * @return string
     */
    public function getMontant(): string
    {
        return $this->montant;
    }

    /**
     * @param string $montant
     */
    public function setMontant(string $montant): void
    {
        $this->montant = $montant;
    }

    /**
     * @return string
     */
    public function getFournisseur(): string
    {
        return $this->fournisseur;
    }

    /**
     * @param string $fournisseur
     */
    public function setFournisseur(string $fournisseur): void
    {
        $this->fournisseur = $fournisseur;
    }


    /**
     * @return NoteFrais|null
     */
    public function getNoteFrais(): ?NoteFrais
    {
        return $this->noteFrais;
    }

    /**
     * @param NoteFrais|null $noteFrais
     */
    public function setNoteFrais(?NoteFrais $noteFrais): void
    {
        $this->noteFrais = $noteFrais;
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
    public function getDateCreation(): string
    {
        return $this->dateCreation;
    }

    /**
     * @param string $dateCreation
     */
    public function setDateCreation(string $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @return string|null
     */
    public function getUrlJustificatif(): ?string
    {
        return $this->urlJustificatif;
    }

    /**
     * @param string|null $urlJustificatif
     */
    public function setUrlJustificatif(?string $urlJustificatif): void
    {
        $this->urlJustificatif = $urlJustificatif;
    }

    /**
     * @return string
     */
    public function getCommentaire(): string
    {
        return $this->commentaire;
    }

    /**
     * @param string $commentaire
     */
    public function setCommentaire(string $commentaire): void
    {
        $this->commentaire = $commentaire;
    }


}