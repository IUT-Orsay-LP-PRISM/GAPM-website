<?php

namespace App\controllers;

use App\models\entity\Administration;
use App\models\entity\Demandeur;
use App\models\entity\Depense;
use App\models\entity\Intervenant;
use App\models\entity\Session;
use Doctrine\ORM\EntityManager;
use function Symfony\Component\String\u;

class PersonnelController extends Template
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function index(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        self::render('/personnel/home.twig', [
            'title' => 'Accueil',
            'nav' => 'home',
        ], true);
    }

    public function loginView(): void
    {
        if (Session::isLoggedAdmin()){
            header('Location: ./?action=home');
        }

        self::render('login.twig', [
            'title' => 'Connexion Personnel',

        ], true);
    }

    public function loginSubmit(): void
    {
        $id = $_POST['login'];
        $password = $_POST['password'];

        $isValid = !empty($id) && !empty($password);

        if ($isValid) {
            $salt = "sel";
            $saltedAndHashed = crypt($password, $salt);

            $personnelRepository = $this->entityManager->getRepository(Administration::class);
            $personnel = $personnelRepository->findOneBy([
                'login' => $id,
            ]);
            $personnelExists = !empty($personnel);

            if ($personnelExists) {
                $user = $personnel;

                if ($user->getMotDePasse() == $saltedAndHashed) {
                    Session::set('admin', $user);

                    header('Location: ./?action=intervenants&message=Vous êtes connecté.&c=msg-success');
                } else {
                    header("Location: ./?action=login&message=Adresse email ou mot de passe incorrect.&c=msg-error");
                }
            } else {
                header("Location: ./?action=login&message=Identifiant ou mot de passe incorrect.&c=msg-error");
            }
        } else {
            header("Location: ./?action=login&message=Veuillez compléter les champs.&c=msg-warning");
        }
    }

    public function logoutSubmit(): void
    {
        Session::destroy(false);
        header('Location: ./?action=login&message=Vous êtes déconnecté.&c=msg-success');
    }

    public function intervenantsView(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        $page = $_GET['page'] ?? 0;

        $intervenantRepository = $this->entityManager->getRepository(Intervenant::class);
        $intervenants = $intervenantRepository->findAll();
        $intervenantsChunked = array_chunk($intervenants, 5);
        $intervenants = $intervenantsChunked[$page];
        $pageNumbers = count($intervenantsChunked);

        self::render('/personnel/intervenants.twig', [
            'title' => 'Gestion des intervenants',
            'nav' => 'intervenants',
            'intervenants' => $intervenants,
            'page' => $page,
            'pageNumbers' => $pageNumbers,
            'pageDisplay' => true,
        ], true);
    }

    public function searchIntervenantsView(): void{
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        $query = $_GET['search'];

        $intervenantRepository = $this->entityManager->getRepository(Intervenant::class);
        $intervenants = $intervenantRepository->findByNameLike($query);

        self::render('/personnel/intervenants.twig', [
            'title' => 'Gestion des intervenants',
            'nav' => 'intervenants',
            'intervenants' => $intervenants,
            'pageDisplay' => false,
        ], true);
    }


    public function intervenantView(): void{
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }
        $id = htmlspecialchars($_GET['id']);

        $intervenant = $this->entityManager->getRepository(Demandeur::class)->find($id);
        $rdvIntervenant = $intervenant->getMesRendezVous();

        $intervenant = $this->entityManager->getRepository(Intervenant::class)->findOneBy([
            'idDemandeur' => $id,
        ]);
        $depenses = $this->entityManager->getRepository(Depense::class)->findBy([
            'intervenant' => $intervenant->getIdDemandeur(),
        ]);

        self::render('/personnel/intervenant.twig', [
            'title' => 'Profil de l\'intervenant ' . $intervenant->getPrenom() . ' ' . $intervenant->getNom(),
            'nav' => 'intervenants',
            'int' => $intervenant,
            'rdv' => $rdvIntervenant,
            'depenses' => $depenses,
        ], true);
    }


    public function planningsView(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        self::render('/personnel/plannings.twig', [
            'title' => 'Gestion des plannings',
            'nav' => 'plannings',
        ], true);
    }

    public function notesFraisView(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        self::render('/personnel/notes-frais.twig', [
            'title' => 'Gestion des notes de frais',
            'nav' => 'notes',
        ], true);
    }

    public function empruntsVehiculesView(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        self::render('/personnel/emprunts.twig', [
            'title' => 'Gestion des emprunts de véhicules',
            'nav' => 'vehicles',
        ], true);
    }

}