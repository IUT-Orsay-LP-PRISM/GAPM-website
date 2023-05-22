<?php

namespace App\controllers;

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
        self::render('/personnel/home.twig', [
            'title' => 'Accueil Personnel',
        ], true);
    }

    public function login()
    {
        self::render('login.twig', [
            'title' => 'Connexion Personnel',

        ], true);
    }
}