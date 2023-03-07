<?php
namespace App\models\entity;

use App\models\repository\DemandeurRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeurRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap(['demandeur' => Demandeur::class, 'intervenant' => Intervenant::class])]
#[ORM\Table(name: 'Demandeur')]
class Demandeur
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    protected int $idDemandeur;
    #[ORM\Column(unique: true)]
    private string $login;
    #[ORM\Column(unique: true)]
    private string $email;
    #[ORM\Column]
    private string $motDePasse;
    #[ORM\Column]
    private string $nom;
    #[ORM\Column]
    private string $prenom;
    #[ORM\Column]
    private string $dateNaissance;
    #[ORM\Column]
    private string $adresse;
    #[ORM\Column]
    private string $telephone;
    #[ORM\Column]
    private string $sexe;
    #[ORM\ManyToOne(targetEntity: Ville::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'idVille', referencedColumnName: 'idVille', nullable: false)]
    private Ville $ville;
    #[ORM\OneToMany(mappedBy: 'demandeur', targetEntity: RendezVous::class, fetch: 'LAZY')]
    private $rendezVous;

    #

    /**
     * @return mixed
     */
    public function getIdDemandeur()
    {
        return $this->idDemandeur;
    }

    /**
     * @param mixed $idDemandeur
     */
    public function setIdDemandeur($idDemandeur): void
    {
        $this->idDemandeur = $idDemandeur;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    /**
     * @param mixed $motDePasse
     */
    public function setMotDePasse($motDePasse): void
    {
        $this->motDePasse = $motDePasse;
    }

    /**
     * @return mixed
     */
    public function getNom()
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
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @param mixed $dateNaissance
     */
    public function setDateNaissance($dateNaissance): void
    {
        $this->dateNaissance = $dateNaissance;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param mixed $sexe
     */
    public function setSexe($sexe): void
    {
        $this->sexe = $sexe;
    }

    /**
     * @return Ville
     */
    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    /**
     * @param Ville $ville
     */
    public function setVille(Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getRendezVous(): array
    {
        return $this->rendezVous->toArray();
    }

    public function setRendezVous(Collection $rendezVous): self
    {
        $this->rendezVous = $rendezVous;

        return $this;
    }

    public function addRendezVous(Rendezvous $rendezvous): self
    {
        if (!$this->rendezVous->contains($rendezvous)) {
            $this->rendezVous[] = $rendezvous;
            $rendezvous->setDemandeur($this);
        }

        return $this;
    }

    public function removeRendezvous(Rendezvous $rendezvous): self
    {
        if ($this->rendezVous->contains($rendezvous)) {
            $this->rendezVous->removeElement($rendezvous);
            if ($rendezvous->getDemandeur() === $this) {
                $rendezvous->setDemandeur(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

}
