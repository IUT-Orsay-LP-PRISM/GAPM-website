<?php
namespace App\models\entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'Demandeur')]
class Demandeur
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private $idDemandeur;
    #[ORM\Column(unique: true)]
    private $login;
    #[ORM\Column(unique: true)]
    private $email;
    #[ORM\Column]
    private $motDePasse;
    #[ORM\Column]
    private $nom;
    #[ORM\Column]
    private $prenom;
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private $dateNaissance;
    #[ORM\Column]
    private $adresse;
    #[ORM\Column]
    private $telephone;
    #[ORM\Column]
    private $sexe;
    #[ORM\ManyToOne(targetEntity: Ville::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'idVille', referencedColumnName: 'idVille', nullable: false)]
    private Ville $ville;

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

}
