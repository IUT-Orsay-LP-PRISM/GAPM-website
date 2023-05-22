<?php

namespace App\models\entity;

use App\models\repository\AdminRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ORM\Table(name: 'Administration')]
class Administration
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $idAdministration;

    #[ORM\Column]
    private string $nom;

    #[ORM\Column]
    private string $prenom;

    #[ORM\Column]
    private string $login;

    #[ORM\Column]
    private string $motDePasse;

    #[ORM\Column]
    private string $email;

    #[ORM\Column]
    private bool $isAdmin;

    public function __construct()
    {

    }

    /**
     * @return int
     */
    public function getIdAdministration(): int
    {
        return $this->idAdministration;
    }

    /**
     * @param int $idAdministration
     */
    public function setIdAdministration(int $idAdministration): void
    {
        $this->idAdministration = $idAdministration;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }

    /**
     * @param string $motDePasse
     */
    public function setMotDePasse(string $motDePasse): void
    {
        $this->motDePasse = $motDePasse;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }


}