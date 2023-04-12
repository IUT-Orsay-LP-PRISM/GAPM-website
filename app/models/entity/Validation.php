<?php

namespace App\models\entity;

class Validation{

    /* FONCTION A ADAPTER POUR AJOUTER ACCEDER AUX VALEUR A TRAVERS DES PARAMETRES !!!!!!!!!!!!!! */
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


    public static function verifierEmail($mail){
        // Caractères autorisés : lettres, numèros, [.-_] et 1 seul @
        // Pas de début ou fin avec [.-_] 
        // ET pas de [.-_] consécutifs
        // Taille maximale 50 caractères

        if($mail != null && $mail != "" && strlen($mail)<=50){
            return preg_match('/^(?![\.\-\_])(?!.*\.\.)(?!.*\-\-)(?!.*\_\_)[A-Za-z0-9\.\-\_]*[A-Za-z0-9]+@[A-Za-z0-9][A-Za-z0-9\-\_]*[A-Za-z0-9]\.[A-Za-z]{2,}$/', $mail) == 1 ? true : false;
        }
        return false;
    }


    public static function verifierDateNaissance($birthday){
        if($birthday != ""){
            $datePostFormatTime = strtotime($birthday);

            if($datePostFormatTime != ''){
                $aujourdhui = new DateTime(date('Y-m-d'));
                $datePost = new DateTime($birthday);

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


    public static function verifierAdresse($address){
        if($address != ""){
            return preg_match('/^[A-Za-z0-9,\-\/\' ]{0,49}$/', $address) == 1 ? true : false;
        }
        return false;
    }


    public static function verifierVille($city){
        if($city != ""){
            if(is_numeric($city) && intval($city) >= 1 && intval($city) <= 36208 ){
                return true;
            }
        }
        return false;
    }


    public static function verifierSexe($sex){
        if($sex != ""){
            return preg_match('/^[HFA]{1}$/', $sex) == 1 ? true : false;
        }
        return false;
    }


    public static function verifierNumeroTelephone($telephone){
        if($telephone != ""){
            return preg_match('/(0|\+33|0033)[1-9][0-9]{8}/', $telephone) == 1 ? true : false;
        }
        return false;
    }


    public static function verifierMdp($password){
        // >= 1 Majuscule + >= 1 minuscule + >= 1 chiffre + >= 1 caractère @$!%*?&
        if($password != ""){
            return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,50}$/', $password) == 1 ? true : false;
        }
        return false;
    }


    public static function verifierSpecialites($specialites){
        if($specialites != ""){
            return preg_match('/^[0-9]+(-[0-9]+)*$/', $specialites) == 1 ? true : false;
        }
        return false;
    }



























    public static function verifierLogin($login){

        if($login != ""){
            return preg_match('/^[A-Za-z0-9\._]{4,50}$/', $login) == 1 ? true : false;
        }
        return false;
    }


    public static function verifierDateRendezVous($date){

        $jour = date("l");
        $mois = date("m");
        $annee = date("Y");
        if($date != ""){
            return preg_match('/^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19\d\d|20[0-2]\d)$/', $date) == 1 ? true : false;
        }
        return false;
    }


    /*
    function verifierCodePostal($postalCode){
        if($postalCode != ""){
            return preg_match('/^(0[1-9]|[1-8]\d|9[0-8])([0-9]{3})$/', $postalCode) == 1 ? true : false;
        }
        return false;
    }
    */
}
?>