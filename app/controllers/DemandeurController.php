<?php

namespace App\controllers;

use App\models\entity\Demandeur;
use App\models\entity\Intervenant;
use App\models\entity\Session;
use App\models\entity\Ville;
use App\models\repository\DemandeurRepository;
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
        $demandeurs = $this->demandeurRepository->findAll();
        $intervenants = $this->entityManager->getRepository(Intervenant::class)->findAll();

        dump($demandeurs);
        echo "-----------";
        dump($intervenants);

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

            $demandeur = new Demandeur();
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

            // On persist => on dit à doctrine de garder en mémoire l'objet
            $this->entityManager->persist($demandeur);
            // On flush => on dit à doctrine d'écrire dans la base de données
            $this->entityManager->flush();

            // TODO : gérer register intervenant ; update field type = demandeur > intervenant ; créer intervenant&
            if ($inscriptionIntervenant) {
                $intervenant = new Intervenant();
                $intervenant->setIdIntervenant($demandeur->getIdDemandeur());
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

    public function displayMyAccount()
    {
        $user = Session::get('user');

        self::render('demandeur/mon-compte.twig', [
            'title' => 'Mon compte',
            'demandeur' => $user,
        ]);
    }
}