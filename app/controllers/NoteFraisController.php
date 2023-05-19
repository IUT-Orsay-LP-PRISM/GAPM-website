<?php

namespace App\controllers;

use App\models\entity\Depense;
use App\models\entity\Intervenant;
use App\models\entity\NoteFrais;
use App\models\entity\Session;
use App\models\repository\NoteFraisRepository;
use Doctrine\ORM\EntityManager;

class NoteFraisController extends Template
{
    private NoteFraisRepository $noteFraisRepository;
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->noteFraisRepository = $entityManager->getRepository(NoteFrais::class);
    }

    public function displayNoteFrais()
    {
        if (!Session::isLogged()) {
            header('Location: /?action=search&message=Pour voir vos notes de frais, veuillez vous identifier&c=connexion');
            exit;
        }
        $depensesAtraiter = $this->entityManager->getRepository(Depense::class)->findBy(['intervenant' => Session::get('user')->getIdDemandeur(), 'noteFrais' => null, 'status' => 'À traiter']);
        $depensesAdeclarer = $this->entityManager->getRepository(Depense::class)->findBy(['intervenant' => Session::get('user')->getIdDemandeur(), 'noteFrais' => null, 'status' => 'À déclarer']);

        $noteFrais = $this->noteFraisRepository->findBy(['intervenant' => Session::get('user')->getIdDemandeur()]);

        $depenses = [
            'Atraiter' => $depensesAtraiter,
            'Adeclarer' => $depensesAdeclarer
        ];

        self::render('demandeur/notes-de-frais.twig', [
            'title' => 'Notes de frais',
            'depenses' => $depenses,
            'noteFrais' => $noteFrais
        ]);

    }

    public function createDepense()
    {
        if (!Session::isLogged()) {
            header('Location: /?action=search&message=Pour ajouter une dépense, veuillez vous identifier&c=connexion');
            exit;
        }

        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find(Session::get('user')->getIdDemandeur());

        $urlJustificatif = $_POST['urlJustificatif'];
        $nature = $_POST['nature'];
        $datePaiement = $_POST['datePaiement'];
        $montant = $_POST['montant'];
        $fournisseur = $_POST['fournisseur'];
        $commentaire = $_POST['commentaire'];
        $dateCreation = date('Y-m-d');
        $status = 'À traiter';

        $depense = new Depense();
        $depense->setNature($nature);
        $depense->setDatePaiement($datePaiement);
        $depense->setMontant($montant);
        $depense->setFournisseur($fournisseur);
        $depense->setCommentaire($commentaire);
        $depense->setDateCreation($dateCreation);
        $depense->setIntervenant($intervenant);

        if ($urlJustificatif != '') {
            $depense->setUrlJustificatif($urlJustificatif);
            $status = 'À déclarer';
        }
        $depense->setStatus($status);
        $this->entityManager->persist($depense);
        $this->entityManager->flush();

        header('Location: /?action=notes-de-frais&message=Votre dépense a bien été ajoutée&c=msg-success');
        exit;
    }

    public function deleteDepense()
    {
        if (!Session::isLogged()) {
            header('Location: /?action=search&message=Pour supprimer une dépense, veuillez vous identifier&c=connexion');
            exit;
        }

        $idDepense = $_GET['idDepense'];
        if (!isset($idDepense) || empty($idDepense)) {
            header('Location: /?action=notes-de-frais&message=Une erreur est survenue lors de la suppression de votre dépense&c=msg-error');
            exit;
        }

        $depense = $this->entityManager->getRepository(Depense::class)->find($idDepense);
        $this->entityManager->remove($depense);
        $this->entityManager->flush();

        header('Location: /?action=notes-de-frais&message=Votre dépense a bien été supprimée&c=msg-success');
        exit;
    }

    public function updateDepense()
    {
        if (!Session::isLogged()) {
            header('Location: /?action=search&message=Pour modifier une dépense, veuillez vous identifier&c=connexion');
            exit;
        }

        $idDepense = $_GET['idDepense'];
        if (!isset($idDepense) || empty($idDepense)) {
            header('Location: /?action=notes-de-frais&message=Une erreur est survenue lors de la modification de votre dépense&c=msg-error');
            exit;
        }

        $urlJustificatif = $_POST['urlJustificatif'];
        $nature = $_POST['nature'];
        $datePaiement = $_POST['datePaiement'];
        $montant = $_POST['montant'];
        $fournisseur = $_POST['fournisseur'];
        $commentaire = $_POST['commentaire'];
        $status = 'À traiter';

        $depense = $this->entityManager->getRepository(Depense::class)->find($idDepense);
        $depense->setNature($nature);
        $depense->setDatePaiement($datePaiement);
        $depense->setMontant($montant);
        $depense->setFournisseur($fournisseur);
        $depense->setCommentaire($commentaire);

        if ($urlJustificatif != '') {
            $depense->setUrlJustificatif($urlJustificatif);
            $status = 'À déclarer';
        }
        $depense->setStatus($status);
        $this->entityManager->persist($depense);
        $this->entityManager->flush();
        header('Location: /?action=notes-de-frais&message=Votre dépense a bien été modifiée&c=msg-success');
        exit;
    }


    public function ajax()
    {
        $idDepense = $_GET['idDepense'];
        if (!isset($idDepense) || empty($idDepense)) {
            echo json_encode(['error' => 'Une erreur est survenue lors de la modification de votre dépense']);
            exit;
        }
        $depense = $this->entityManager->getRepository(Depense::class)->find($idDepense);
        $depense_json = json_encode(
            [
                'nature' => $depense->getNature(),
                'datePaiement' => $depense->getDatePaiement(),
                'montant' => $depense->getMontant(),
                'fournisseur' => $depense->getFournisseur(),
                'commentaire' => $depense->getCommentaire(),
                'urlJustificatif' => $depense->getUrlJustificatif()
            ]
        );
        echo $depense_json;
    }
}