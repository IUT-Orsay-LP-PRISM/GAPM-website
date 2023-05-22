<?php

namespace App\controllers;

use App\models\entity\Administration;
use App\models\entity\Session;
use Doctrine\ORM\EntityManager;

class PersonnelController extends Template
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function index()
    {

        dump(Session::get('admin'));
        self::render('/personnel/home.twig', [
            'title' => 'Accueil Personnel',
        ], true);
    }

    public function loginView()
    {
        self::render('login.twig', [
            'title' => 'Connexion Personnel',

        ], true);
    }

    public function loginSubmit()
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
}