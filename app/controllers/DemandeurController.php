<?php

namespace App\controllers;

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

    public static function login(){
        $email = $_POST['email'];
        $password  = $_POST['password'];

        var_dump($_POST);
        $salt= "legrosseldeguerande";
        $saltedAndHashed = crypt($password,$salt);
        var_dump($saltedAndHashed);
        if(DemandeurDAO::checkIfEmailExists($email)){
            $userPassword = DemandeurDAO::getPasswordFromEmail($email);
            if($userPassword->getMotDePasse() == $saltedAndHashed){
                Session::set('connected',1);
                die("Connecté");
            }
            else{
                die("Mauvais mot de passe");
            }
        }
        else{
            die("L'utilisateur demandé n'existe pas");
        }
    }
}