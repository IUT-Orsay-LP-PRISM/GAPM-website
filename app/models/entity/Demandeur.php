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
    #[ORM\ManyToOne(targetEntity: Ville::class)]
    #[ORM\JoinColumn(name: 'idVille', referencedColumnName: 'idVille')]
    private Ville $ville;

}
