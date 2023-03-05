<?php

namespace App\controllers;

interface InterfaceController
{
    /**
     * @return mixed
     * Fonction pour SELECT toutes les données
     */
    public function index(): mixed;

    /**
     * @return mixed
     * Fonction pour INSERER des données 'CREATE'
     */
    public function store(): mixed;

    /**
     * @return mixed
     * Fonction pour VOIR les détails d'une donnée 'READ'
     */
    public function show(): mixed;

    /**
     * @return mixed
     * Fonction pour UPDATE des données 'UPDATE'
     */
    public function update(): mixed;

    /**
     * @return mixed
     * Fonction pour DELETE des données 'DELETE'
     */
    public function delete(): mixed;


}