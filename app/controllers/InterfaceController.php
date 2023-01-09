<?php

namespace App\controllers;

interface InterfaceController
{
    /**
     * @return mixed
     * Fonction pour SELECT toutes les données
     */
    public static function index();

    /**
     * @return mixed
     * Fonction pour INSERER des données 'CREATE'
     */
    public static function store();

    /**
     * @return mixed
     * Fonction pour VOIR les détails d'une donnée 'READ'
     */
    public static function show();

    /**
     * @return mixed
     * Fonction pour UPDATE des données 'UPDATE'
     */
    public static function update();

    /**
     * @return mixed
     * Fonction pour DELETE des données 'DELETE'
     */
    public static function delete();


}