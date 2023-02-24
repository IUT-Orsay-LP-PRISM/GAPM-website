<?php

namespace App\models\DAO;

use App\models\entity\Demandeur;

use PDO;
use PDOException;

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
            self::$db = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbName, self::$user, self::$passwd, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$db;
    }

    /**
     * Fonction générique permettant de select all
     */
    public static function findAll()
    {
        try {
            $query = "SELECT * FROM " . static::$entity;
            $rs = self::getInstance()->query($query);
            $rs->setFetchMode(PDO::FETCH_CLASS, 'App\models\entity\\' . static::$entity);
            return $rs->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * Fonction générique permettant de select by id
     */
    public static function findById(int $id)
    {
        try {
            $query = "SELECT * FROM " . static::$entity. " WHERE id_" . static::$entity. " = :id";

            $rs = self::getInstance()->prepare($query);
            $rs->setFetchMode(PDO::FETCH_CLASS, 'App\models\entity\\' . static::$entity);
            $rs->execute(
                [":id" => $id]
            );
            return $rs->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * Fonction générique permettant de remove by id
     */

    public static function removeById(int $id)
    {
        try {
            $query = "DELETE FROM " . static::$entity. " WHERE id_" . static::$entity. " = :id";

            $rs = self::getInstance()->prepare($query);
            $rs->execute(
                [":id" => $id]
            );
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}


