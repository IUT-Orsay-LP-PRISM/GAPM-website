<?php

namespace App\controllers;

use App\models\entity\Intervenant;
use App\models\entity\Session;
use App\models\entity\Specialite;
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
                $referer = self::addErrorToUrl('Veuillez choisir au moins une spécialité.', 'inscription-intervenant');
                header("Location: $referer");
                exit();
            }
            $specialitesString = $_POST['specialites'];
            if ($specialitesString != 'null') {
                $specialites = explode('-', $specialitesString);
            }
            $specialites = $this->entityManager->getRepository(Specialite::class)->findBy(['idSpecialite' => $specialites]);

            $currentUser = Session::get('user');
            $this->entityManager->getRepository(Demandeur::class)->changeDiscriminatorValue('intervenant', $currentUser->getIdDemandeur());
            $currentDemandeur = $this->entityManager->getRepository(Demandeur::class)->findOneBy(['idDemandeur' => $currentUser->getIdDemandeur()]);
            $currentDemandeur->setSpecialites(new ArrayCollection($specialites));

            try {
                $this->entityManager->persist($currentDemandeur);
                $this->entityManager->flush();
                Session::set('user', $currentDemandeur);
            } catch (\Exception $e) {
                $referer = self::addErrorToUrl('Une erreur est survenue.', 'inscription-intervenant');
                header("Location: $referer");
                exit();
            }
            header("Location: /");
        }
    }
}