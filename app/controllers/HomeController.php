<?php

namespace App\controllers;

/**
 * @template-extends Héritage de Template pour que les classes enfants puisse utiliser la méthode render beaucoup plus simplement
 */
class HomeController extends Template
{
    public function index(): mixed
    {
        self::render('home.twig', [
            'title' => 'Accueil - Bienvenue',
            'type' => 'home'
        ]);

        return null;
    }

}