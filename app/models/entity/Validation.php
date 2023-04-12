<?php

namespace App\models\entity;

class Validation{

    function verifierNomPrenom(){
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


    function verifierDateNaissance(){
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


    function verifierAdresse(){
        if(isset($_POST["address"]) && $_POST["address"] != ""){
            return preg_match('/^[A-Za-z0-9,\-\/\' ]{0,49}$/', $_POST["address"]);
        }
        return false;
    }


    function verifierVille(){
        if(isset($_POST["city"]) && $_POST["city"] != ""){
            if(is_numeric($_POST["city"]) && intval($_POST["city"]) >= 1 && intval($_POST["city"]) <= 36208 ){
                return true;
            }
        }
        return false;
    }


    function verifierSexe(){
        if(isset($_POST["sexe"]) && $_POST["sexe"] != ""){
            return preg_match('/^[HFA]{1}$/', $_POST["sexe"]);
        }
        return false;
    }


    function verifierNumeroTelephone(){
        if(isset($_POST["phone"]) && $_POST["phone"] != ""){
            return preg_match('/(0|\+33|0033)[1-9][0-9]{8}/', $_POST["phone"]);
        }
        else{
            return false;
        }
    }


    function verifierMdp(){
        // >= 1 Majuscule + >= 1 minuscule + >= 1 chiffre + >= 1 caractère @$!%*?&
        if(isset($_POST["password"]) && $_POST["password"] != ""){
            return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,50}$/', $_POST["password"]);
        }
        else{
            return false;
        }
    }


    function verifierSpecialites(){
        if(isset($_POST["specialites"]) && $_POST["specialites"] != ""){
            return preg_match('/^[0-9]+(-[0-9]+)*$/', $_POST["specialites"]);
        }
        else{
            return false;
        }
    }



























    function verifierLogin(){

        if(isset($_POST["NOMVARIABLE"]) && $_POST["NOMVARIABLE"] != ""){
            return preg_match('/^[A-Za-z0-9\._]{4,50}$/', $_POST["NOMVARIABLE"]);
        }
        else{
            return false;
        }
    }


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


    /*
    function verifierCodePostal(){
        if(isset($_POST["NOMVARIABLE"]) && $_POST["NOMVARIABLE"] != ""){
            return preg_match('/^(0[1-9]|[1-8]\d|9[0-8])([0-9]{3})$/', $_POST["NOMVARIABLE"]);
        }
        else{
            return false;
        }
    }
    */
}
?>