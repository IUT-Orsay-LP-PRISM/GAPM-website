<?php

namespace App\models\entity;

use App\models\repository\IntervenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
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

    #[ORM\ManyToOne(targetEntity: Ville::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'idVillePro', referencedColumnName: 'idVille', nullable: false)]
    private Ville $villePro;

    #[ORM\Column]
    private string $imgUrl;

    #[ORM\Column]
    private bool $demandeSupp;

    #[ORM\OneToMany(mappedBy: 'intervenant', targetEntity: RendezVous::class, fetch: 'LAZY')]
    private Collection $mesRendezVous;

    public float $note;

    private $status;

    public function __construct()
    {
        $this->specialites = new ArrayCollection();
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
     * @param ArrayCollection $specialites
     */
    public function setSpecialites(ArrayCollection $specialites): void
    {
        $this->specialites = $specialites;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function isValid(): bool
    {
        if($this->status == 1){
            return true;
        }
        else{
            return false;
        }
    }

    public function isIntervenant(): bool
    {
        return true;
    }

    /**
     * @return Ville
     */
    public function getVillePro(): Ville
    {
        return $this->villePro;
    }

    /**
     * @param Ville $villePro
     */
    public function setVillePro(Ville $villePro): void
    {
        $this->villePro = $villePro;
    }

    public function getNoteAvg(): float
    {
        return $this->note;
    }

    public function setNoteAvg(float $note): void
    {
        $this->note = $note;
    }

    public function getImgUrl(): string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(string $imgUrl): void
    {
        $this->imgUrl = $imgUrl;
    }

    /**
     * @return bool
     */
    public function isDemandeSupp(): bool
    {
        return $this->demandeSupp;
    }

    /**
     * @param bool $demandeSupp
     */
    public function setDemandeSupp(bool $demandeSupp): void
    {
        $this->demandeSupp = $demandeSupp;
    }

    /**
     * @return array
     */
    public function getMesRendezVous(): array
    {
        return $this->mesRendezVous->toArray();
    }

    /**
     * @param Collection $rendezVous
     */
    public function setMesRendezVous(Collection $rendezVous): Demandeur
    {
        $this->mesRendezVous = $rendezVous;
    }

}
