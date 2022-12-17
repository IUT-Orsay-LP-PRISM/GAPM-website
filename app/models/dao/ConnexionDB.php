<?php

namespace App\models\dao;

use PDO;

class ConnexionDB
{

    /**
     * @var PDO Design Pattern Singleton - En gros : une seule instance de connexion à la BDD pour éviter de créer X objets DB, on en créer finalement qu'un seul
     */
    private static $db = null;
    private static string $host = "localhost";
    private static string $dbName = "projet";
    private static string $user = "root";
    private static string $passwd = "";

    /**
     * @return PDO Retourne l'instance de connexion à la BDD, si y'a aucune instance de connexion, on en crée une.
     */
    public static function getInstance()
    {
        if (is_null(self::$db)) {
            self::$db = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbName, self::$user, self::$passwd);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$db;
    }

}

