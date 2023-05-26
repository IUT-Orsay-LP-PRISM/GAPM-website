<?php

namespace App\controllers;

use App\models\entity\Administration;
use App\models\entity\Intervenant;
use App\models\entity\Session;
use Doctrine\ORM\EntityManager;

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

                    header('Location: ./?action=home&message=Vous êtes connecté.&c=msg-success');
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

        $intervenantRepository = $this->entityManager->getRepository(Intervenant::class);
        $intervenants = $intervenantRepository->findAll();

        self::render('/personnel/intervenants.twig', [
            'title' => 'Gestion des intervenants',
            'nav' => 'intervenants',
            'intervenants' => $intervenants,
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