<?php

namespace App\controllers;

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

        ], true);
    }
}