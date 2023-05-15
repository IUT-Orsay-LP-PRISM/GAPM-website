<?php

namespace App\controllers;

use App\models\entity\Demandeur;
use App\models\entity\Intervenant;
use App\models\entity\Session;
use App\models\entity\Specialite;
use App\models\entity\TypeVoiture;
use App\models\entity\Ville;
use App\models\entity\Voiture;
use App\models\entity\Emprunt;
use App\models\repository\IntervenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

class IntervenantController extends Template
{
    private IntervenantRepository $intervenantRepository;
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->intervenantRepository = $entityManager->getRepository(Intervenant::class);
    }

    public function index()
    {
        self::render('inscription_intervenant.twig', [
            'title' => "Inscription d'un intervenant",
            'type' => 'inscription',
            'isIntervenant' => true,
            'no_header' => true,
        ]);
    }

    public function devenirIntervenant()
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

    public function update()
    {
        if (isset($_POST['specialites'])) {
            if ($_POST['specialites'] == 'null') {
                $referer = self::addMessageToUrl('Veuillez choisir au moins une spécialité.', 'my-account');
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
                $referer = self::addMessageToUrl('Une erreur est survenue.', 'my-account');
                header("Location: $referer");
                exit();
            }
            header("Location: /");
        }
    }


    public function toggleModeIntervenant()
    {
        $sessionMode = Session::get('modeIntervenant');
        if ($sessionMode == null) {
            Session::set('modeIntervenant', true);
        } else {
            Session::set('modeIntervenant', !$sessionMode);
        }
        header("Location: /");
    }

    public function emprunterVehicule()
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
}