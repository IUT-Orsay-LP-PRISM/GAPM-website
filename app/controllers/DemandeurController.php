<?php

namespace App\controllers;

use App\models\entity\Demandeur;
use App\models\dao\VilleDAO;
use App\models\dao\DemandeurDAO;
use App\models\entity\Session;

abstract class DemandeurController extends Template implements InterfaceController
{
    public static function index()
    {
        $lesDemandeurs = DemandeurDAO::findAll();
        $unDemandeur = DemandeurDAO::findById(5);

        self::render('demandeur/liste-demandeur.twig', [
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

    private function addErrorToUrl($error, $containerError): string
    {
        $referer = $_SERVER['HTTP_REFERER'];
        $referer_parts = parse_url($referer);
        if (isset($referer_parts['query'])) {
            parse_str($referer_parts['query'], $query_params);
            $query_params['error'] = $error;
            $referer_parts['query'] = http_build_query($query_params);
            $referer = $referer_parts['scheme'] . '://' . $referer_parts['host'] . $referer_parts['path'] . '?' . $referer_parts['query'];
        } else {
            $referer .= '?error=' . $error . '&c=' . $containerError;
        }
        return $referer;
    }

    public static function login()
    {
        function removeErrorFromUrl(): string
        {
            $referer = $_SERVER['HTTP_REFERER'];
            $referer_parts = parse_url($referer);
            if (isset($referer_parts['query'])) { // remove error query param
                parse_str($referer_parts['query'], $query_params);
                unset($query_params['error']);
                $referer_parts['query'] = http_build_query($query_params);
                $referer = $referer_parts['scheme'] . '://' . $referer_parts['host'] . $referer_parts['path'] . '?' . $referer_parts['query'];
            }
            return $referer;
        }

        // TODO: faire la fonction pour valider chaque champs en regex
        if (!empty($_POST['email']) && !empty($_POST['password']) && isset($_POST['email']) && isset($_POST['password'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $salt = "sel";
            $saltedAndHashed = crypt($password, $salt);
            if (DemandeurDAO::checkIfEmailExists($email)) {
                $user = DemandeurDAO::getUserFromEmail($email);
                if ($user->getMotDePasse() == $saltedAndHashed) {
                    Session::set('user', $user);

                    $referer = removeErrorFromUrl();
                    header('Location: ' . $referer);
                } else {
                    $referer = self::addErrorToUrl('Adresse email ou mot de passe incorrect.', 'connexion');
                    header("Location: $referer");
                }
            } else {
                $referer = self::addErrorToUrl('Adresse email ou mot de passe incorrect.', 'connexion');
                header("Location: $referer");
            }
        } else {
            $referer = self::addErrorToUrl('Veuillez remplir tous les champs.', 'connexion');
            header("Location: $referer");
        }
    }


    public static function register()
    {
        $email = $_POST['mail'];
        $user = DemandeurDAO::getUserFromEmail($email);
        if ($user) {
            $referer = self::addErrorToUrl('Cette email est déjà utilisé.', 'inscription');
            header("Location: $referer");
        } else {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $birthday = $_POST['birthday'];
            $password = $_POST['password'];
            $city = $_POST['city'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $sexe = $_POST['sexe'];

            $salt = "sel";
            $saltedAndHashed = crypt($password, $salt);
            $demandeur = new Demandeur();
            $demandeur->setNom($lastname);
            $demandeur->setPrenom($firstname);
            $demandeur->setEmail($email);
            $demandeur->setDateNaissance($birthday);
            $demandeur->setAdresse($address);
            $demandeur->setIdVille($city);
            $demandeur->setMotDePasse($saltedAndHashed);
            $demandeur->setTelephone($phone);
            $demandeur->setSexe($sexe);

            $demandeur = DemandeurDAO::create($demandeur);
            if ($demandeur) {
                Session::set('user', $demandeur);
                header('Location: /');
            } else {
                header('Location: /');
            }
        }
    }


    public static function logout()
    {
        Session::destroy();
        header('Location: /');
    }

    public static function myAccount()
    {
        $user = Session::get('user');
        $demandeur = DemandeurDAO::findById($user->getIdDemandeur());
        $ville = VilleDAO::findById($demandeur->getId_Ville());

        self::render('demandeur/mon-compte.twig', [
            'demandeur' => $demandeur,
            'loader' => false,
            'title' => 'Mon compte',
            'ville' => $ville,
            'view' => $_GET['view'] ?? 'perso',
        ]);
    }

}