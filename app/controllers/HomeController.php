<?php

namespace App\controllers;

/**
 * @template-extends Héritage de Template pour que les classes enfants puisse utiliser la méthode render beaucoup plus simplement
 */
class HomeController extends Template
{
    public function index()
    {
        self::render('home.twig', [
            'title' => 'Accueil - Bienvenue',
            'type' => 'home'
        ]);
    }

    public function displayFAQ()
    {
        self::render('faq.twig', [
            'title' => "Besoin d'\aide ",
        ]);
    }

    public function displayForgotten()
    {
        self::render('forgotten.twig', [
            'title' => "Oubli de mot de passe ",
        ]);
    }

    public function display404()
    {
        self::render('404.html', [
            'title' => '404 - Page introuvable',
        ]);
    }

}