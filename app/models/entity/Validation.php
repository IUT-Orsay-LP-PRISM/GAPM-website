<?php

namespace App\models\entity;

use DateTime;

class Validation{

    public static $errorMessagesArray = [
        "Format du prénom incorrect",
        "Format du nom incorrect",
        "Format du mail incorrect",
        "Date de naissance incorrecte",
        "Format de l'adresse incorrecte",
        "Ville renseignée non valable",
        "Sexe renseigné non valable",
        "Format du mot de passe incorrect",
        "Format du téléphone incorrect",
        "Format des spécialités incorrect"
    ];

    public static $inscriptionDemandeurFonctions ; // initialisé avec Validation::init()
    public static $inscriptionIntervenantFonctions ; // initialisé avec Validation::init()
    public static $connexionDemandeurFonctions ; // initialisé avec Validation::init()



    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // Méthodes



    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // Fonction verifierNomPrenom : vérification du regex des champs prenom/nom via $_POST
    // Retourne booléen : true = pas d'erreur / false = erreur
    public static function verifierNomPrenom(){
        $tab = ["firstname", "lastname"];

        foreach($tab as $value){
            if(isset($_POST[$value]) && $_POST[$value] != ""){
                if(preg_match('/^[A-Za-z][A-Za-z ]{0,49}$/', $_POST[$value])){
                    if($value === array_key_last($tab)){
                        return true;
                    }
                    else{
                        continue;
                    }
                }
            }
            return false;
        }
    }



    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // Fonction verifierPrenom : vérification du regex du champ prenom via $_POST
    // Retourne booléen : true = pas d'erreur / false = erreur
    public static function verifierPrenom(){
        if(isset($_POST["firstname"]) && $_POST["firstname"] != ""){
            return preg_match('/^[\p{L}\p{M}][\p{L}\p{M} ]{0,49}$/u', $_POST['firstname']);
        }
        return false;
    }



    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // Fonction verifierNom : vérification du regex du champ nom via $_POST
    // Retourne booléen : true = pas d'erreur / false = erreur
    public static function verifierNom(){
        if(isset($_POST["lastname"]) && $_POST["lastname"] != ""){
            return preg_match('/^[\p{L}\p{M}][\p{L}\p{M} ]{0,49}$/u', $_POST['lastname']);
        }
        return false;
    }



    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // Fonction verifierEmail : vérification du regex du champ email via $_POST
    // Retourne booléen : true = pas d'erreur / false = erreur
    public static function verifierEmail(){
        // Caractères autorisés : lettres, numèros, [.-_] et 1 seul @
        // Pas de début ou fin avec [.-_]
        // ET pas de [.-_] consécutifs
        // Taille maximale 50 caractères

        if(isset($_POST["mail"]) && $_POST["mail"] != "" && strlen($_POST["mail"])<=50){
            return preg_match('/^(?![\.\-\_])(?!.*\.\.)(?!.*\-\-)(?!.*\_\_)[A-Za-z0-9\.\-\_]*[A-Za-z0-9]+@[A-Za-z0-9][A-Za-z0-9\-\_]*[A-Za-z0-9]\.[A-Za-z]{2,}$/', $_POST["mail"]);
        }
        else{
            return false;
        }
    }



    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // Fonction verifierDateNaissance : vérification du regex du champ date de naissance via $_POST
    // Retourne booléen : true = pas d'erreur / false = erreur
    public static function verifierDateNaissance(){
        if(isset($_POST["birthday"]) && $_POST["birthday"] != ""){
            $datePostFormatTime = strtotime($_POST["birthday"]);

            if($datePostFormatTime != ''){
                    $aujourdhui = new DateTime(date('Y-m-d'));
                $datePost = new DateTime($_POST["birthday"]);

                $diff = $datePost->diff($aujourdhui);

                return ($diff->y) >= 18;
            }
        }
        return false;

        /*
        if(isset($_POST["NOMVARIABLE"]) && $_POST["NOMVARIABLE"] != ""){
            return preg_match('/^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19\d\d|20[0-2]\d)$/', $_POST["NOMVARIABLE"]);
        }
        else{
            return false;
        }
        */
    }



    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // Fonction verifierAdresse : vérification du regex du champ adresse via $_POST
    // Retourne booléen : true = pas d'erreur / false = erreur
    public static function verifierAdresse(){
        if(isset($_POST["address"]) && $_POST["address"] != ""){
            return preg_match('/^[A-Za-z0-9,\-\/\' ]{0,49}$/', $_POST["address"]);
        }
        return false;
    }



    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // Fonction verifierVille : vérification du regex du champ ville via $_POST
    // Retourne booléen : true = pas d'erreur / false = erreur
    public static function verifierVille(){
        if(isset($_POST["city"]) && $_POST["city"] != ""){
            if(is_numeric($_POST["city"]) && intval($_POST["city"]) >= 1 && intval($_POST["city"]) <= 36208 ){
                return true;
            }
        }
        return false;
    }



    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // Fonction verifierSexe : vérification du regex du champ sexe via $_POST
    // Retourne booléen : true = pas d'erreur / false = erreur
    public static function verifierSexe(){
        if(isset($_POST["sexe"]) && $_POST["sexe"] != ""){
            return preg_match('/^[MFA]{1}$/', $_POST["sexe"]);
        }
        return false;
    }



    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // Fonction verifierMdp : vérification du regex du champ mot de passe via $_POST
    // Retourne booléen : true = pas d'erreur / false = erreur
    public static function verifierMdp(){
        // >= 1 Majuscule + >= 1 minuscule + >= 1 chiffre + >= 1 caractère @$!%*?&
        if(isset($_POST["password"]) && $_POST["password"] != ""){
            return true;
            // preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,50}$/', $_POST["password"]);
        }
        else{
            return false;
        }
    }



    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // Fonction verifierNumeroTelephone : vérification du regex du champ numéro téléphone via $_POST
    // Retourne booléen : true = pas d'erreur / false = erreur
    public static function verifierNumeroTelephone(){
        if(isset($_POST["phone"]) && $_POST["phone"] != ""){
            return preg_match('/(0|\+33|0033)[1-9][0-9]{8}/', $_POST["phone"]);
        }
        else{
            return false;
        }
    }



    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // Fonction verifierSpecialites : vérification du regex du champ spécialités via $_POST
    // Retourne booléen : true = pas d'erreur / false = erreur
    public static function verifierSpecialites(){
        if(isset($_POST["specialites"]) && $_POST["specialites"] != ""){
            return preg_match('/^[0-9]+(-[0-9]+)*$/', $_POST["specialites"]);
        }
        else{
            return false;
        }
    }



    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // Fonction verifierFormulaire($arrayFonctions) : vérifie toutes les expressions régulières d'un
    // formulaire, en fonction à l'array statique de la classe passé en paramètre
    // Retourne array de strings : string = message d'erreur pour une regexp / null = pas d'erreur
    public static function verifierFormulaire($arrayFonctions){
        // Déclaration + initialisation de l'array des messages d'erreur à retourner
        $errorMessagesReturn = array_fill(0, count($arrayFonctions), NULL);

        // Vérification des regex + affectation des messages d'erreur
        for($i = 0; $i < count($errorMessagesReturn); $i++){
            $errorMessagesReturn[$i] = call_user_func($arrayFonctions[$i][0]) ? NULL : $arrayFonctions[$i][1];
        }

        return $errorMessagesReturn;
    }



    /*
        // PLUS D'ACTUALITÉ

        // --------------------------------------------------------------------------------------------------------
        // --------------------------------------------------------------------------------------------------------
        // Fonction verifierLogin :
        function verifierLogin(){

            if(isset($_POST["NOMVARIABLE"]) && $_POST["NOMVARIABLE"] != ""){
                return preg_match('/^[A-Za-z0-9\._]{4,50}$/', $_POST["NOMVARIABLE"]);
            }
            else{
                return false;
            }
        }


        // --------------------------------------------------------------------------------------------------------
        // --------------------------------------------------------------------------------------------------------
        // Fonction verifierDateRendezVous :
        function verifierDateRendezVous(){

            $jour = date("l");
            $mois = date("m");
            $annee = date("Y");
            if(isset($_POST["NOMVARIABLE"]) && $_POST["NOMVARIABLE"] != ""){
                return preg_match('/^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19\d\d|20[0-2]\d)$/', $_POST["NOMVARIABLE"]);
            }
            else{
                return false;
            }
        }



        // --------------------------------------------------------------------------------------------------------
        // --------------------------------------------------------------------------------------------------------
        // Fonction verifierCodePostal :
        function verifierCodePostal(){
            if(isset($_POST["NOMVARIABLE"]) && $_POST["NOMVARIABLE"] != ""){
                return preg_match('/^(0[1-9]|[1-8]\d|9[0-8])([0-9]{3})$/', $_POST["NOMVARIABLE"]);
            }
            else{
                return false;
            }
        }
        */



    // --------------------------------------------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------------
    // Fonction init : initialisation des variables array statiques contenant les fonctions à lancer pour
    // chaque contrôle + le message d'erreur lié au résultat
    static function init(){

        // Initialisation array fonction/message erreur : inscription demandeur
        Validation::$inscriptionDemandeurFonctions = array(
            array('self::verifierPrenom', self::$errorMessagesArray[0]),
            array('self::verifierNom', static::$errorMessagesArray[1]),
            array('self::verifierEmail', static::$errorMessagesArray[2]),
            array('self::verifierDateNaissance', static::$errorMessagesArray[3]),
            array('self::verifierAdresse', static::$errorMessagesArray[4]),
            array('self::verifierVille', static::$errorMessagesArray[5]),
            array('self::verifierSexe', static::$errorMessagesArray[6]),
            array('self::verifierMdp', static::$errorMessagesArray[7]),
            array('self::verifierNumeroTelephone', static::$errorMessagesArray[8])
        );

        // Initialisation array fonction/message erreur : inscription intervenant
        Validation::$inscriptionIntervenantFonctions = array(
            array('self::verifierPrenom', self::$errorMessagesArray[0]),
            array('self::verifierNom', static::$errorMessagesArray[1]),
            array('self::verifierEmail', static::$errorMessagesArray[2]),
            array('self::verifierDateNaissance', static::$errorMessagesArray[3]),
            array('self::verifierAdresse', static::$errorMessagesArray[4]),
            array('self::verifierVille', static::$errorMessagesArray[5]),
            array('self::verifierSexe', static::$errorMessagesArray[6]),
            array('self::verifierMdp', static::$errorMessagesArray[7]),
            array('self::verifierNumeroTelephone', static::$errorMessagesArray[8]),
            array('self::verifierSpecialites', static::$errorMessagesArray[9]),
            array('self::verifierAdresse', static::$errorMessagesArray[4]), // AdressePro
            array('self::verifierVille', static::$errorMessagesArray[5]) // VillePro
        );

        // Initialisation array fonction/message erreur : connexion demandeur/intervenant
        Validation::$connexionDemandeurFonctions = array(
            array('self::verifierEmail', static::$errorMessagesArray[2]),
            array('self::verifierMdp', static::$errorMessagesArray[7])
        );
    }
}

// Lancement de l'initialisation des variables array statiques
Validation::init();
?>