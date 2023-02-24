<?php

namespace App\controllers;

use App\models\entity\Demandeur;
use App\models\dao\VilleDAO;
use App\models\dao\DemandeurDAO;
use App\models\entity\Session;
use App\models\entity\Intervenant;
use App\models\dao\IntervenantDAO;


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
        $user = Session::get('user');
        $demandeur = DemandeurDAO::findById($user->getIdDemandeur());
        $email = $_POST['mail'];
        $userFromEmail = DemandeurDAO::getUserFromEmail($email);

        $salt = "sel";
        $saltedAndHashed = crypt($_POST['oldPassword'], $salt);
        $oldPassword = $saltedAndHashed;
        $password = $demandeur->getMotDePasse();

        if($oldPassword == $demandeur->getMotDePasse()){
            if(!empty($_POST['newPassword'])) {
                $salt = "sel";
                $saltedAndHashed = crypt($_POST['newPassword'], $salt);
                $password = $saltedAndHashed;
            }
        }else{
            $referer = self::addErrorToUrl('Ancien mot de passe incorrect.', 'mon-compte');
            header("Location: $referer");
            exit();
        }


        if ($userFromEmail && $userFromEmail->getIdDemandeur() != $user->getIdDemandeur()) {
            $referer = self::addErrorToUrl('Cette email est déjà utilisé.', 'mon-compte');
            header("Location: $referer");
            exit();
        } else {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $birthday = $_POST['birthday'];
            $city = $_POST['city'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $sexe = $_POST['sexe'];

            $demandeur->setNom($lastname);
            $demandeur->setPrenom($firstname);
            $demandeur->setEmail($email);
            $demandeur->setDateNaissance($birthday);
            $demandeur->setAdresse($address);
            $demandeur->setIdVille($city);
            $demandeur->setMotDePasse($password);
            $demandeur->setTelephone($phone);
            $demandeur->setSexe($sexe);

            $demandeur = DemandeurDAO::update($demandeur);

            if ($demandeur) {
                Session::set('user', $demandeur);
                header('Location: /?action=my-account');
            } else {
                header('Location: /');
            }
        }
    }

    public static function delete()
    {
        $email = $_POST['email'];
        if ($email != $_SESSION['user']->getEmail()) {
            header('Location: /?action=my-account');
        } else {
            $user = Session::get('user');
            $demandeur = DemandeurDAO::removeById($user->getIdDemandeur());

            $isIntervenant = IntervenantDAO::findById($user->getIdDemandeur());
            $isIntervenant ? IntervenantDAO::removeById($user->getIdDemandeur()) : null;

            //TODO :  soit mettre la bdd en cascade delete soit faire a la main les delete des Service tout le reste

            if ($demandeur) {
                Session::destroy();
                header('Location: /');
            } else {
                header('Location: /?action=my-account');
            }
        }
    }

    public static function show()
    {
        // TODO: Implement show() method.
    }

    private static function addErrorToUrl($error, $containerError): string
    {
        $referer = $_SERVER['HTTP_REFERER'];
        $referer_parts = parse_url($referer);
        if (isset($referer_parts['query'])) {
            parse_str($referer_parts['query'], $query_params);
            $query_params['error'] = $error;
            $query_params['c'] = $containerError;
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
        $inscriptionIntervenant = false;
        $voiture = 0;
        $specialites = [];
        $containerError = 'inscription';
        if (isset($_POST['specialites'])) {
            $inscriptionIntervenant = true;
            $containerError = 'inscription-intervenant';
            $specialitesString = $_POST['specialites'];
            if ($specialitesString != 'null') {
                $specialites = explode('-', $specialitesString);
            }
            $voiture = $_POST['voiture'] ?? 0;
        }

        $email = $_POST['mail'];
        $user = DemandeurDAO::getUserFromEmail($email);
        if ($user) {
            $referer = self::addErrorToUrl('Cette email est déjà utilisé.', $containerError);
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

            if ($inscriptionIntervenant) {
                $intervenant = new Intervenant();
                $intervenant->setId_Intervenant($demandeur->getIdDemandeur());
                $intervenant->setSpecialites($specialites);
                //$intervenant->setVoiture($voiture);
                // TODO : ajouter voiture et demande voiture

                $intervenant = IntervenantDAO::create($intervenant);
            }

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