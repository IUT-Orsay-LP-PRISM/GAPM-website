<?php

namespace App\controllers;

use App\models\repository\AdminRepository;
use Doctrine\ORM\EntityManager;

class PersonnelController extends Template
{
    private AdminRepository $personnelRepository;
    private EntityManager $entityManager;

}