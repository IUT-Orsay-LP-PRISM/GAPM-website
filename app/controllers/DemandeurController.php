<?php

namespace App\controllers;

use App\models\entity\Demandeur;
use Bcrypt\Bcrypt;
use App\models\dao\DemandeurDAO;
use App\models\entity\Session;

abstract class DemandeurController extends Template implements InterfaceController
{
    public static function index()
    {
        $lesDemandeurs = DemandeurDAO::findAll();
        $unDemandeur = DemandeurDAO::findById(5);

        self::render('demandeur/demandeurList.twig', [
            'lesDemandeurs' => $lesDemandeurs,
            'unDemandeur' => $unDemandeur,
        ]);
    }

    public static function store()
    {
        // TODO: Implement store() method.
    }

    public static function update()
    {
        // TODO: Implement update() method.
    }

    public static function delete()
    {
        // TODO: Implement delete() method.
    }

    public static function show()
    {
        // TODO: Implement show() method.
    }

    public static function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $salt= "sel";
        $saltedAndHashed = crypt($password,$salt);
        if(DemandeurDAO::checkIfEmailExists($email)){
            $user = DemandeurDAO::getUserFromEmail($email);
            if($user->getMotDePasse() == $saltedAndHashed){
                Session::start();
                Session::set('user', $user);
                header("Location: /?action=demandeur");
            } else{
                header("Location: /?error=Adresse email ou mot de passe incorrect.");
            }
        } else{
            header("Location: /?error=Adresse email ou mot de passe incorrect.");
        }
    }

    public static function register(){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['mail'];
        $birthday = $_POST['birthday'];
        $password = $_POST['password'];
        $city = $_POST['city'];
        $cp = $_POST['cp'];
        $phone = $_POST['phone'];

        $salt= "sel";
        $saltedAndHashed = crypt($password,$salt);
        $demandeur = new Demandeur();
        $demandeur->setNom($lastname);
        $demandeur->setPrenom($firstname);
        $demandeur->setEmail($email);
        $demandeur->setDateNaissance($birthday);
        $demandeur->setMotDePasse($saltedAndHashed);
    }
}