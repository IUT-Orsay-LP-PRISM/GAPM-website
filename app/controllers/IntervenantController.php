<?php

namespace App\controllers;

abstract class IntervenantController extends Template implements InterfaceController
{

    /**
     * @inheritDoc
     */
    public static function index()
    {
        self::render('inscription_intervenant.twig', [
            'title' => "Inscription d'un intervenant",
            'type' => 'inscription',
            'isIntervenant' => true,
            'no_header' => true,
        ]);
    }

    /**
     * @inheritDoc
     */
    public static function store()
    {
        // TODO: Implement store() method.
    }

    /**
     * @inheritDoc
     */
    public static function show()
    {
        // TODO: Implement show() method.
    }

    /**
     * @inheritDoc
     */
    public static function update()
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public static function delete()
    {
        // TODO: Implement delete() method.
    }
}