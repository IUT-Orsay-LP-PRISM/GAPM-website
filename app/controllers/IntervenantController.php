<?php

namespace App\controllers;

use App\models\entity\Demandeur;
use App\models\entity\Intervenant;
use App\models\entity\Session;
use App\models\entity\Specialite;
use App\models\entity\Ville;
use App\models\entity\Voiture;
use App\models\entity\Emprunt;
use App\models\repository\IntervenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Intervention\Image\ImageManagerStatic as Image;


class IntervenantController extends Template
{
    private IntervenantRepository $intervenantRepository;
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->intervenantRepository = $entityManager->getRepository(Intervenant::class);
    }

    public function profile(): void
    {
        $idIntervenant = htmlspecialchars($_GET['id']);
        $intervenant = $this->intervenantRepository->find($idIntervenant);

        if ($intervenant == null || !is_numeric($idIntervenant)) {
            $referer = self::addMessageToUrl('Cette Intervenant n\'existe pas.', 'msg-error');
            header("Location: $referer");
            exit();
        }

        $notes = $this->intervenantRepository->findNoteById($idIntervenant);
        $avg = null;
        if ($notes != null) {
            foreach ($notes as $note) {
                $avg += $note['note'];
            }
            $avg = $avg / count($notes);
            $avg = round($avg, 1);
        }

        self::render('intervenant/profile.twig', [
            'title' => 'Profil de : ' . $intervenant->getPrenom() . ' ' . $intervenant->getNom(),
            'notes' => $notes,
            'note' => $avg,
            'int' => $intervenant,
        ]);
    }

    public function index(): void
    {
        self::render('inscription_intervenant.twig', [
            'title' => "Inscription d'un intervenant",
            'type' => 'inscription',
            'isIntervenant' => true,
            'no_header' => true,
        ]);
    }

    public function devenirIntervenant(): void
    {
        if (isset($_POST['specialites'])) {
            if ($_POST['specialites'] == 'null') {
                $referer = self::addMessageToUrl('Veuillez choisir au moins une spécialité.', 'inscription-intervenant');
                header("Location: $referer");
                exit();
            }
            $specialitesString = $_POST['specialites'];
            if ($specialitesString != 'null') {
                $specialites = explode('-', $specialitesString);
            }

            $addressPro = $_POST['addressPro'];
            $IdCityPro = $_POST['city'];
            $villePro = $this->entityManager->getRepository(Ville::class)->findOneBy(['idVille' => $IdCityPro]);

            $specialites = $this->entityManager->getRepository(Specialite::class)->findBy(['idSpecialite' => $specialites]);
            $currentUser = Session::get('user');
            $this->entityManager->getRepository(Demandeur::class)->changeDiscriminatorValue('intervenant', $currentUser->getIdDemandeur());
            $currentDemandeur = $this->entityManager->getRepository(Demandeur::class)->findOneBy(['idDemandeur' => $currentUser->getIdDemandeur()]);

            $currentDemandeur->setSpecialites(new ArrayCollection($specialites));
            $currentDemandeur->setAdressePro($addressPro);
            $currentDemandeur->setVillePro($villePro);

            try {
                $this->entityManager->persist($currentDemandeur);
                $this->entityManager->flush();
                Session::set('user', $currentDemandeur);
            } catch (\Exception $e) {
                $referer = self::addMessageToUrl('Une erreur est survenue.', 'inscription-intervenant');
                header("Location: $referer");
                exit();
            }
            header("Location: /");
        }
    }

    public function update(): void
    {
        if (isset($_POST['specialites'])) {
            if ($_POST['specialites'] == 'null') {
                $referer = self::addMessageToUrl('Veuillez choisir au moins une spécialité.', 'msg-warning');
                header("Location: $referer");
                exit();
            }
            $specialitesString = $_POST['specialites'];
            if ($specialitesString != 'null') {
                $specialites = explode('-', $specialitesString);
            }

            $oldPassword = $_POST['oldPassword'];
            $currentPassword = Session::get('user')->getMotDePasse();


            $salt = "sel";
            $saltedAndHashed = crypt($_POST['oldPassword'], $salt);
            $oldPassword = $saltedAndHashed;
            if ($oldPassword != $currentPassword) {
                $referer = self::addMessageToUrl('Mot de passe incorrect.', 'msg-error');
                header("Location: $referer");
                exit();
            }

            $addressPro = $_POST['adressePro'];
            $IdCityPro = $_POST['city'];
            $villePro = $this->entityManager->getRepository(Ville::class)->findOneBy(['idVille' => $IdCityPro]);

            $specialites = $this->entityManager->getRepository(Specialite::class)->findBy(['idSpecialite' => $specialites]);
            $currentUser = Session::get('user');
            $currentDemandeur = $this->entityManager->getRepository(Demandeur::class)->findOneBy(['idDemandeur' => $currentUser->getIdDemandeur()]);
            $currentDemandeur->setSpecialites(new ArrayCollection($specialites));
            $currentDemandeur->setAdressePro($addressPro);
            $currentDemandeur->setVillePro($villePro);

            try {
                $this->entityManager->persist($currentDemandeur);
                $this->entityManager->flush();
                Session::set('user', $currentDemandeur);

            } catch (\Exception $e) {
                $referer = self::addMessageToUrl('Une erreur est survenue.', 'msg-error');
                header("Location: $referer");
                exit();
            }
            $referer = self::addMessageToUrl('Vos informations ont bien été modifiées.', 'msg-success');
            header("Location: $referer");
        }
    }


    public function toggleModeIntervenant(): void
    {
        $sessionMode = Session::get('modeIntervenant');
        if ($sessionMode == null) {
            Session::set('modeIntervenant', true);
        } else {
            Session::set('modeIntervenant', !$sessionMode);
        }
        header("Location: /");
    }

    public function emprunterVehicule(): void
    {
        $idTypeVoiture = $_POST['typeVehicule'];
        $dateDebut = $_POST['dateDu'];
        $dateFin = $_POST['dateAu'];

        $voituresByType = $this->entityManager->getRepository(Voiture::class)->findBy(['typeVoiture' => $idTypeVoiture]);
        $emprunts = $this->entityManager->getRepository(Emprunt::class)->findAll();
        $empruntsEnCours = array_filter($emprunts, fn($emprunt) => $emprunt->getDateFin() > (new \DateTime())->format('Y-m-d'));
        $voitureDispo = array_filter($voituresByType, fn($voiture) => !in_array($voiture, array_map(fn($emprunt) => $emprunt->getVoiture(), $empruntsEnCours)));
        $voitureDispo = reset($voitureDispo);


        if ($voitureDispo == null) {
            $referer = self::addMessageToUrl('Aucun véhicule disponible.', 'my-account');
            header("Location: $referer");
            exit();
        }

        $idIntervenant = Session::get('user')->getIdDemandeur();
        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find($idIntervenant);

        $emprunt = new Emprunt();
        $emprunt->setDateDebut($dateDebut);
        $emprunt->setDateFin($dateFin);
        $emprunt->setVoiture($voitureDispo);
        $emprunt->setIntervenant($intervenant);

        try {
            $this->entityManager->persist($emprunt);
            $this->entityManager->persist($voitureDispo);
            $this->entityManager->flush();
            $referer = self::addMessageToUrl('Véhicule emprunté.', 'msg-success');
            header("Location: $referer");
        } catch (\Exception $e) {
            $referer = self::addMessageToUrl('Une erreur est survenue.', 'my-account');
            header("Location: $referer");
            exit();
        }
    }

    public function updatePicture(): void
    {
        $idIntervenant = Session::get('user')->getIdDemandeur();
        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find($idIntervenant);
        $img = $_FILES['image'];

        // Vérification si le fichier a bien été téléchargé via HTTP POST (donc qu'il a bien été upload)
        if (!is_uploaded_file($img['tmp_name'])) {
            $referer = self::addMessageToUrl('Le fichier n\'a pas été téléchargé via HTTP POST.', 'msg-warning');
            header("Location: $referer");
            exit();
        }

        // Vérification si le fichier est une image
        $check = getimagesize($img['tmp_name']);
        if ($check === false) {
            $referer = self::addMessageToUrl('Le fichier n\'est pas une image.', 'msg-error');
            header("Location: $referer");
            exit();
        }

        // Vérification si l'intervenant existe
        if ($intervenant != null) {
            $pathToSave = 'public/img/intervenants/';
            $random = bin2hex(random_bytes(10));
            $extension = pathinfo($img['name'], PATHINFO_EXTENSION);

            // Vérification de l'extension
            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $referer = self::addMessageToUrl('Extension de fichier non autorisée.', 'msg-error');
                header("Location: $referer");
                exit();
            }
            $path = $pathToSave . $idIntervenant . '-' . $random . '.' . $extension;

            // Mise à jour de l'intervenant
            $intervenant->setImgUrl($path);
            try {
                $this->entityManager->persist($intervenant);
                $this->entityManager->flush();
                Session::set('user', $intervenant);
                move_uploaded_file($img['tmp_name'], $path);

                $image = Image::make($path);
                $image->fit(300, 300);
                $image->save();

                $referer = self::addMessageToUrl('Photo de profil mise à jour.', 'msg-success');
                header("Location: $referer");
            } catch (\Exception $e) {
                $referer = self::addMessageToUrl('Votre photo de profil n\'a pas pu être mise à jour : .' . $e, 'msg-error');
                header("Location: $referer");
                exit();
            }
        }
    }


    public function unsubscribeRequest(): void
    {
        $email = $_POST['email'];
        if ($email != $_SESSION['user']->getEmail()) {
            $referer = self::addMessageToUrl('Email incorrect.', 'msg-error');
            header("Location: $referer");
        } else {
            $idIntervenant = Session::get('user')->getIdDemandeur();
            $intervenant = $this->entityManager->getRepository(Intervenant::class)->find($idIntervenant);
            $intervenant->setDemandeSupp(true);
            try {
                $this->entityManager->persist($intervenant);
                $this->entityManager->flush();
                Session::set('user', $intervenant);
                $referer = self::addMessageToUrl('Votre demande de cessation d\'activité a bien été prise en compte.', 'msg-success');
                header("Location: $referer");
                exit();
            } catch (\Exception $e) {
                $referer = self::addMessageToUrl('Une erreur est survenue.', 'my-account');
                header("Location: $referer");
                exit();
            }
        }
    }

    public function cancelUnsubscribe(): void
    {
        $idIntervenant = Session::get('user')->getIdDemandeur();
        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find($idIntervenant);
        $intervenant->setDemandeSupp(false);
        try {
            $this->entityManager->persist($intervenant);
            $this->entityManager->flush();
            Session::set('user', $intervenant);
            $referer = self::addMessageToUrl('Votre demande de cessation d\'activité a bien été annulée.', 'msg-success');
            header("Location: $referer");
            exit();
        } catch (\Exception $e) {
            $referer = self::addMessageToUrl('Une erreur est survenue.', 'my-account');
            header("Location: $referer");
            exit();
        }
    }

}