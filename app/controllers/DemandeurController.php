<?php

namespace App\controllers;

use App\models\entity\Demandeur;
use App\models\entity\Intervenant;
use App\models\entity\RendezVous;
use App\models\entity\Session;
use App\models\entity\Specialite;
use App\models\entity\TypeVoiture;
use App\models\entity\Ville;
use App\models\entity\Emprunt;
use App\models\entity\Voiture;
use App\models\repository\DemandeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

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
            $referer = self::addMessageToUrl('Ancien mot de passe incorrect.', 'mon-compte');
            header("Location: $referer");
            exit();
        }

        if ($userFromEmail && $userFromEmail->getIdDemandeur() != $demandeur->getIdDemandeur()) {
            $referer = self::addMessageToUrl('Cette email est déjà utilisé.', 'mon-compte');
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
                $referer = self::addMessageToUrl('Une erreur est survenue. Merci de réessayer.', 'mon-compte');
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
            $referer = self::addMessageToUrl('Email incorrect.', 'msg-error');
            header("Location: $referer");
        } else {
            $user = Session::get('user');
            $demandeur = $this->demandeurRepository->findOneBy(['idDemandeur' => $user->getIdDemandeur()]);

            try {
                $this->entityManager->remove($demandeur);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                header('Location: /?action=my-account'."&nav=options");
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
                unset($query_params['message']);
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

                    header('Location: /?message=Vous êtes connecté.&c=success');
                } else {
                    $referer = self::addMessageToUrl('Adresse email ou mot de passe incorrect.', 'connexion');
                    header("Location: $referer");
                }
            } else {
                $referer = self::addMessageToUrl('Adresse email ou mot de passe incorrect.', 'connexion');
                header("Location: $referer");
            }
        } else {
            $referer = self::addMessageToUrl('Veuillez remplir tous les champs.', 'connexion');
            header("Location: $referer");
        }
    }

    public function register()
    {
        $inscriptionIntervenant = false;
        $specialites = [];
        $containerMessage = 'inscription';
        if (isset($_POST['specialites'])) {
            if ($_POST['specialites'] == 'null') {
                $referer = self::addMessageToUrl('Veuillez choisir au moins une spécialité.', 'inscription-intervenant');
                header("Location: $referer");
                exit();
            }
            $inscriptionIntervenant = true;
            $containerMessage = 'inscription-intervenant';
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
            $referer = self::addMessageToUrl('Cette email est déjà utilisé.', $containerMessage);
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
                $demandeur->setImgUrl("public/img/default.jpg");
                $demandeur->setVillePro($villePro);
            }

            try {
                $this->entityManager->persist($demandeur);
                $this->entityManager->flush();
            } catch (Exception $e) {
                $referer = self::addMessageToUrl('Une erreur est survenue.', $containerMessage);
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
        if ($user == null) {
            header('Location: /?message=Veuillez%20vous%20connecter%20pour%20accéder%20à%20votre%20compte&c=connexion');
        } else {
            if (Session::get('user')->isIntervenant() && Session::get('modeIntervenant')) {
                $voitures = $this->entityManager->getRepository(Voiture::class)->findAll();
                $typesVoiture = $this->entityManager->getRepository(TypeVoiture::class)->findAll();
                $emprunts = $this->entityManager->getRepository(Emprunt::class)->findAll();

                $empruntsEnCours = array_filter($emprunts, fn($emprunt) => $emprunt->getDateFin() > (new \DateTime())->format('Y-m-d'));
                $voituresDisponibles = array_filter($voitures, fn($voiture) => !in_array($voiture, array_map(fn($emprunt) => $emprunt->getVoiture(), $empruntsEnCours)));
                $typesVoitureDisponible = array_values((array_filter($typesVoiture, fn($typeVoiture) => in_array($typeVoiture, array_map(fn($voiture) => $voiture->getTypeVoiture(), $voituresDisponibles)))));

                $empruntsDeUser = $this->entityManager->getRepository(Emprunt::class)->findBy(['intervenant' => Session::get('user')->getIdDemandeur()]);

                $empruntsWaiting = array_filter($empruntsDeUser, function ($emprunt) {
                    return property_exists($emprunt, 'administration') && $emprunt->getAdministration() == null && $emprunt->getDateFin() >= date('Y-m-d');
                });

                $empruntsPassed = array_filter($empruntsDeUser, function ($emprunt) {
                    return $emprunt->getDateFin() < date('Y-m-d');
                });

                $empruntsCurrent = array_filter($empruntsDeUser, function ($emprunt) {
                    return $emprunt->getDateDebut() <= date('Y-m-d') && $emprunt->getDateFin() >= date('Y-m-d') && property_exists($emprunt, 'administration') && $emprunt->getAdministration() != null;
                });

                $empruntsUpcoming = array_filter($empruntsDeUser, function ($emprunt) use ($empruntsCurrent) {
                    return $emprunt->getDateFin() >= date('Y-m-d') && property_exists($emprunt, 'administration') && $emprunt->getAdministration() != null && !in_array($emprunt, $empruntsCurrent);
                });


                $emprunts = [
                    'waiting' => $empruntsWaiting,
                    'passed' => $empruntsPassed,
                    'current' => $empruntsCurrent,
                    'upcoming' => $empruntsUpcoming
                ];


                self::render('demandeur/mon-compte.twig', [
                    'title' => 'Mon compte',
                    'typeVehicules' => $typesVoitureDisponible,
                    'emprunts' => $emprunts
                ]);
            } else {
                self::render('demandeur/mon-compte.twig', [
                    'title' => 'Mon compte',
                ]);
            }
        }
    }

    public function forgottenMail(){
        $isValid = !empty($_POST['email']) && isset($_POST['email']);

        if ($isValid) {

            //TODO vérifier chaque champs avec regex
            $email = $_POST['email'];

            // TODO changer le sel par un vrai sel
            $random_hex = bin2hex(random_bytes(10));

            $salt = "sel";
            $saltedAndHashed = crypt($random_hex, $salt);
            $password = $saltedAndHashed;

            $demandeur = $this->demandeurRepository->findOneBy(['email' => $email]);
            $emailExists = !empty($demandeur);

            if ($emailExists) {
                    $demandeur->setMotDePasse($password);
                    try {
                        $this->entityManager->persist($demandeur);
                        $this->entityManager->flush();
                    } catch (\Exception $e) {
                        $referer = self::addMessageToUrl('Une erreur est survenue. Merci de réessayer.', 'connexion');
                        header("Location: $referer");
                        exit();
                    }

                    $phpmailer = new PHPMailer();
                    $phpmailer->isSMTP();
                    $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
                    $phpmailer->SMTPAuth = true;
                    $phpmailer->Port = 2525;
                    $phpmailer->Username = '87aafa94a4e2c8';
                    $phpmailer->Password = '2b192b0e9179d3';
                    $phpmailer->setFrom('no-reply@gapm.com', 'No-reply');
                    $phpmailer->addAddress($email, $demandeur->getNom() . ' ' . $demandeur->getPrenom()); 
                    $phpmailer->Subject = 'Mot de passe oublie';
                    $phpmailer->Body = 'Voici votre mot de passe temporaire : ' . $random_hex;
                    //send the message, check for errors
                    if (!$phpmailer->send()) {
                        echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
                    } else {
                        $referer = self::addMessageToUrl('Si le compte existe, le message a ete envoye', 'connexion');
                        header("Location: $referer");
                    }
            } else {
                $referer = self::addMessageToUrl('Email inconnu', 'connexion');
                header("Location: $referer");
            }
        } else {
            $referer = self::addMessageToUrl('Le champ n\'a pas ete remplis correctement', 'connexion');
            header("Location: $referer");
        }
    }
}