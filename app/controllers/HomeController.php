<?php

namespace App\controllers;

/**
 * @template-extends Héritage de Template pour que les classes enfants puisse utiliser la méthode render beaucoup plus simplement
 */
abstract class HomeController extends Template implements InterfaceController
{
    public static function index()
    {
        self::render('home.twig', [
            'title' => 'Accueil - Bienvenue',
            'type' => 'home'
        ]);
    }
}