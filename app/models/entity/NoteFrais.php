<?php

namespace App\models\entity;

use App\models\repository\NoteFraisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteFraisRepository::class)]
#[ORM\Table(name: 'NoteFrais')]
class NoteFrais
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $idNoteFrais;

    #[ORM\Column]
    private string $dateNote;

    #[ORM\Column]
    private string $status;

    #[ORM\ManyToOne(targetEntity: Intervenant::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'idIntervenant', referencedColumnName: 'idDemandeur', nullable: false)]
    private Intervenant $intervenant;

    #[ORM\OneToMany(mappedBy: 'noteFrais', targetEntity: Depense::class, fetch: 'EAGER')]
    private $depenses;

    #[ORM\ManyToOne(targetEntity: Administration::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'idAdministration', referencedColumnName: 'idAdministration', nullable: true)]
    private ?Administration $administration = null;

    #[ORM\Column]
    private string $message;

    private float $montantTotal = 0;

    /**
     * @return int
     */
    public function getIdNoteFrais(): int
    {
        return $this->idNoteFrais;
    }

    /**
     * @param int $idNoteFrais
     */
    public function setIdNoteFrais(int $idNoteFrais): void
    {
        $this->idNoteFrais = $idNoteFrais;
    }

    /**
     * @return string
     */
    public function getDateNote(): string
    {
        return $this->dateNote;
    }

    /**
     * @param string $dateNote
     */
    public function setDateNote(string $dateNote): void
    {
        $this->dateNote = $dateNote;
    }


    /**
     * @return Administration|null
     */
    public function getAdministration(): ?Administration
    {
        return $this->administration;
    }

    /**
     * @param Administration|null $administration
     */
    public function setAdministration(?Administration $administration): void
    {
        $this->administration = $administration;
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
     * @return float
     */
    public function getMontantTotal(): float
    {
        return $this->montantTotal;
    }

    /**
     * @param float $montantTotal
     */
    public function setMontantTotal(float $montantTotal): void
    {
        $this->montantTotal = $montantTotal;
    }

    /**
     * @return array
     */
    public function getDepenses(): array
    {
        return $this->depenses->toArray();
    }

    /**
     * @param array $depenses
     */
    public function setDepenses(array $depenses): void
    {
        $this->depenses = $depenses;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}