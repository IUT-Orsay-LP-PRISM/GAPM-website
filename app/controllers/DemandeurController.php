<?php

namespace App\controllers;

use App\models\entity\Demandeur;
use App\models\entity\Intervenant;
use App\models\entity\RendezVous;
use App\models\entity\Session;
use App\models\entity\Specialite;
use App\models\entity\Ville;
use App\models\repository\DemandeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;


class DemandeurController extends Template
{
    private DemandeurRepository $demandeurRepository;
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->demandeurRepository = $entityManager->getRepository(Demandeur::class);
    }

    public function index()
    {
        $rdvs = $this->entityManager->getRepository(RendezVous::class)->findAll();
        dump($rdvs);
        die();

        $this->render('demandeur/liste-demandeur.twig', [
            'lesDemandeurs' => $demandeurs,
        ]);
    }

    public function update()
    {

        $user = Session::get('user');
        $demandeur = $this->demandeurRepository->findOneBy(['idDemandeur' => $user->getIdDemandeur()]);
        $email = $_POST['mail'];
        $userFromEmail = $this->demandeurRepository->findOneBy(['email' => $email]);

        $salt = "sel";
        $saltedAndHashed = crypt($_POST['oldPassword'], $salt);
        $oldPassword = $saltedAndHashed;
        $password = $demandeur->getMotDePasse();

        if ($oldPassword == $demandeur->getMotDePasse()) {
            if (!empty($_POST['newPassword'])) {
                $salt = "sel";
                $saltedAndHashed = crypt($_POST['newPassword'], $salt);
                $password = $saltedAndHashed;
            }
        } else {
            $referer = self::addErrorToUrl('Ancien mot de passe incorrect.', 'mon-compte');
            header("Location: $referer");
            exit();
        }

        if ($userFromEmail && $userFromEmail->getIdDemandeur() != $demandeur->getIdDemandeur()) {
            $referer = self::addErrorToUrl('Cette email est déjà utilisé.', 'mon-compte');
            header("Location: $referer");
            exit();
        } else {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $birthday = $_POST['birthday'];
            $cityId = $_POST['city'];
            $city = $this->entityManager->getRepository(Ville::class)->findOneBy(['idVille' => $cityId]);
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $sexe = $_POST['sexe'];

            $demandeur->setNom($lastname);
            $demandeur->setPrenom($firstname);
            $demandeur->setEmail($email);
            $demandeur->setDateNaissance($birthday);
            $demandeur->setAdresse($address);
            $demandeur->setVille($city);
            $demandeur->setMotDePasse($password);
            $demandeur->setTelephone($phone);
            $demandeur->setSexe($sexe);

            try {
                $this->entityManager->persist($demandeur);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                $referer = self::addErrorToUrl('Une erreur est survenue. Merci de réessayer.', 'mon-compte');
                header("Location: $referer");
                exit();
            }
            Session::set('user', $demandeur);
            header('Location: /?action=my-account');
        }
    }

    public function delete()
    {
        $email = $_POST['email'];
        if ($email != $_SESSION['user']->getEmail()) {
            header('Location: /?action=my-account');
        } else {
            $user = Session::get('user');
            $demandeur = $this->demandeurRepository->findOneBy(['idDemandeur' => $user->getIdDemandeur()]);

            try {
                $this->entityManager->remove($demandeur);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                header('Location: /?action=my-account');
            }
            Session::destroy();
            header('Location: /');
        }
    }



    public function login()
    {
        function removeErrorFromUrl(): string
        {
            $referer = $_SERVER['HTTP_REFERER'];
            $referer_parts = parse_url($referer);
            if (isset($referer_parts['query'])) {
                parse_str($referer_parts['query'], $query_params);
                unset($query_params['error']);
                unset($query_params['c']);
                $referer_parts['query'] = http_build_query($query_params);
                $referer = $referer_parts['scheme'] . '://' . $referer_parts['host'] . $referer_parts['path'] . '?' . $referer_parts['query'];
            }
            return $referer;
        }

        $isValid = !empty($_POST['email']) && !empty($_POST['password']) && isset($_POST['email']) && isset($_POST['password']);

        if ($isValid) {

            //TODO vérifier chaque champs avec regex
            $email = $_POST['email'];
            $password = $_POST['password'];

            // TODO changer le sel par un vrai sel
            $salt = "sel";
            $saltedAndHashed = crypt($password, $salt);

            $demandeur = $this->demandeurRepository->findOneBy(['email' => $email]);
            $emailExists = !empty($demandeur);

            if ($emailExists) {
                $user = $demandeur;

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

    public function register()
    {
        $inscriptionIntervenant = false;
        $specialites = [];
        $containerError = 'inscription';
        if (isset($_POST['specialites'])) {
            if ($_POST['specialites'] == 'null') {
                $referer = self::addErrorToUrl('Veuillez choisir au moins une spécialité.', 'inscription-intervenant');
                header("Location: $referer");
                exit();
            }
            $inscriptionIntervenant = true;
            $containerError = 'inscription-intervenant';
            $specialitesString = $_POST['specialites'];
            if ($specialitesString != 'null') {
                $specialites = explode('-', $specialitesString);
            }
        }

        // TODO vérifier champ
        $email = $_POST['mail'];

        $demandeur = $this->demandeurRepository->findOneBy(['email' => $email]);
        $emailExists = !empty($demandeur);

        if ($emailExists) {
            $referer = self::addErrorToUrl('Cette email est déjà utilisé.', $containerError);
            header("Location: $referer");
        } else {
            // TODO vérifier chaque champs ; faire une classe de vérification ?
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

            $cityId = (int)$city;
            $ville = $this->entityManager->getRepository(Ville::class)->find($cityId);
            $login = strtolower($firstname . "." . $lastname);

            $type = $inscriptionIntervenant ? 'intervenant' : 'demandeur';

            $demandeur = $inscriptionIntervenant ? new Intervenant() : new Demandeur();
            $demandeur->setNom($lastname);
            $demandeur->setLogin($login);
            $demandeur->setPrenom($firstname);
            $demandeur->setEmail($email);
            $demandeur->setDateNaissance($birthday);
            $demandeur->setAdresse($address);
            $demandeur->setMotDePasse($saltedAndHashed);
            $demandeur->setTelephone($phone);
            $demandeur->setSexe($sexe);
            $demandeur->setVille($ville);
            $demandeur->setType($type);

            if ($inscriptionIntervenant) {
                $adressePro = $_POST['adressePro'];
                $IdCityPro = $_POST['cityPro'];
                $specialites = $this->entityManager->getRepository(Specialite::class)->findBy(['idSpecialite' => $specialites]);
                $villePro = $this->entityManager->getRepository(Ville::class)->findOneBy(['idVille' => $IdCityPro]);
                $demandeur->setSpecialites(new ArrayCollection($specialites));
                $demandeur->setAdressePro($adressePro);
                $demandeur->setVillePro($villePro);
            }

            try {
                $this->entityManager->persist($demandeur);
                $this->entityManager->flush();
            } catch (Exception $e) {
                $referer = self::addErrorToUrl('Une erreur est survenue.', $containerError);
                header("Location: $referer");
                exit();
            }
            Session::set('user', $demandeur);
            header('Location: /');
        }
    }


    public static function logout()
    {
        Session::destroy();
        header('Location: /');
    }

    public function displayMyAccount()
    {
        $user = Session::get('user');
        if($user == null){
            header('Location: /?error=Veuillez%20vous%20connecter%20pour%20accéder%20à%20votre%20compte&c=connexion');
        }
        else{
            self::render('demandeur/mon-compte.twig', [
                'title' => 'Mon compte'
            ]);
        }
        
    }
}