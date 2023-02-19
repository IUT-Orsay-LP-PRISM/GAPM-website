<?php

namespace App\controllers;

use App\models\dao\DemandeurDAO;

abstract class InscriptionIntervenenantController extends Template implements InterfaceController
{
    public static function index()
    {
        self::render('inscription_intervenant.twig', [
            'title' => "Inscription d'un intervenant",
            'type' => 'inscription',
            'isIntervenant' => true,
            'no_header' => true,
        ]);
    }
}