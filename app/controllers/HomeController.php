<?php

namespace App\controllers;

/**
 * @template-extends Héritage de Template pour que les classes enfants puisse utiliser la méthode render beaucoup plus simplement
 */
class HomeController extends Template implements InterfaceController
{
    public function index(): mixed
    {
        self::render('home.twig', [
            'title' => 'Accueil - Bienvenue',
            'type' => 'home'
        ]);
    }

    public function store(): mixed
    {
        // TODO: Implement store() method.
    }

    public function show(): mixed
    {
        // TODO: Implement show() method.
    }

    public function update(): mixed
    {
        // TODO: Implement update() method.
    }

    public function delete(): mixed
    {
        // TODO: Implement delete() method.
    }
}