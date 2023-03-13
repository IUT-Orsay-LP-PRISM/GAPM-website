<?php

namespace App\controllers;

use Doctrine\ORM\EntityManager;

class CommentaireController extends Template
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }



}