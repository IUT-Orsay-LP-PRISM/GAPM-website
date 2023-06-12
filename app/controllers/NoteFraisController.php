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
        $depensesDeclarer = $this->entityManager->getRepository(Depense::class)->findBy(['intervenant' => Session::get('user')->getIdDemandeur(), 'status' => 'déclarer']);

        $allNoteFrais = $this->noteFraisRepository->findBy(['intervenant' => Session::get('user')->getIdDemandeur()]);

        $depenses = [
            'Atraiter' => $depensesAtraiter,
            'Adeclarer' => $depensesAdeclarer,
            'Declarer' => $depensesDeclarer
        ];

        $TotalRemboursementsEnAttente = 0;
        foreach ($depensesDeclarer as $depense) {
            $noteFrais = $depense->getNoteFrais();
            $TotalRemboursementsEnAttente += ($noteFrais->getStatus() == 'en attente' && $noteFrais->getAdministration() == null) ? $depense->getMontant() : 0;
        }

        // montant total pour render
        $montantTotal = 0;
        foreach ($allNoteFrais as $noteFraisForTotal) {
            $depensesForTotal = $this->entityManager->getRepository(Depense::class)->findBy((['noteFrais' => $noteFrais->getIdNoteFrais()]));
            foreach ($depensesForTotal as $depenseForTotal) {
                $montantTotal += $depenseForTotal->getMontant();
            }
            $noteFraisForTotal->setMontantTotal($montantTotal);
        }

        self::render('intervenant/notes-de-frais.twig', [
            'title' => 'Notes de frais',
            'depenses' => $depenses,
            'noteFrais' => $allNoteFrais,
            'TotalRemboursementsEnAttente' => $TotalRemboursementsEnAttente
        ]);

    }

    public function createDepense()
    {
        if (!Session::isLogged()) {
            header('Location: /?action=search&message=Pour ajouter une dépense, veuillez vous identifier&c=connexion');
            exit;
        }
        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find(Session::get('user')->getIdDemandeur());

        if ($intervenant == null) {
            header('Location: /?action=notes-de-frais&message=Une erreur est survenue lors de l\'ajout de votre dépense&c=msg-error');
            exit;
        }

        $urlJustificatif = $this->uploadJustificatif($intervenant);

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

        $urlJustificatif = $depense->getUrlJustificatif();
        if ($urlJustificatif != '') {
            unlink($urlJustificatif);
        }

        $this->entityManager->remove($depense);
        $this->entityManager->flush();

        header('Location: /?action=notes-de-frais&message=Votre dépense a bien été supprimée&c=msg-success');
        exit;
    }

    private function uploadJustificatif($intervenant, $oldUrlJustificatif = '')
    {
        if ($oldUrlJustificatif != '') {
            unlink($oldUrlJustificatif);
        }
        $urlJustificatif = '';
        $justificatif = $_FILES['urlJustificatif'];

        // Vérification si le fichier a été uploadé (si le champ est vide, c'est qu'il n'a pas été uploadé)
        if (isset($justificatif['tmp_name']) && !empty($justificatif['tmp_name'])) {
            // Vérification si le fichier a bien été téléchargé via HTTP POST (donc qu'il a bien été upload)
            if (!is_uploaded_file($justificatif['tmp_name'])) {
                $referer = self::addMessageToUrl('Le fichier n\'a pas été téléchargé via HTTP POST.', 'msg-warning');
                header("Location: $referer");
                exit();
            }

            // Vérification si le fichier est une image ou un pdf
            $check = getimagesize($justificatif['tmp_name']);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
            if (!in_array($check['mime'], $allowedTypes)) {
                $referer = self::addMessageToUrl('Le fichier n\'est pas une image ou un pdf.', 'msg-warning');
                header("Location: $referer");
                exit();
            }

            $pathToSave = 'public/uploads/intervenants/docs/';
            $random = bin2hex(random_bytes(10));
            $extension = pathinfo($justificatif['name'], PATHINFO_EXTENSION);

            // Vérification de l'extension
            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'pdf'])) {
                $referer = self::addMessageToUrl('Extension de fichier non autorisée.', 'msg-error');
                header("Location: $referer");
                exit();
            }

            $urlJustificatif = $pathToSave . $intervenant->getIdDemandeur() . '-' . $random . '.' . $extension;

            // Déplacement du fichier
            if (!move_uploaded_file($justificatif['tmp_name'], $urlJustificatif)) {
                $referer = self::addMessageToUrl('Une erreur est survenue lors de l\'upload du fichier.', 'msg-error');
                header("Location: $referer");
                exit();
            }
        }
        return $urlJustificatif;
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

        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find(Session::get('user')->getIdDemandeur());

        if ($intervenant == null) {
            header('Location: /?action=notes-de-frais&message=Une erreur est survenue lors de l\'ajout de votre dépense&c=msg-error');
            exit;
        }

        $depense = $this->entityManager->getRepository(Depense::class)->find($idDepense);

        $urlJustificatif = $this->uploadJustificatif($intervenant, $depense->getUrlJustificatif());

        $nature = $_POST['nature'];
        $datePaiement = $_POST['datePaiement'];
        $montant = $_POST['montant'];
        $fournisseur = $_POST['fournisseur'];
        $commentaire = $_POST['commentaire'];
        $status = 'À traiter';

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

    public function prepareDepenses()
    {

        if (!Session::isLogged()) {
            header('Location: /?action=search&message=Pour modifier une dépense, veuillez vous identifier&c=connexion');
            exit;
        }

        $arrayIds = explode(',', $_POST['arrayIds']);
        if (!isset($arrayIds) || empty($arrayIds)) {
            header('Location: /?action=notes-de-frais&message=Une erreur est survenue lors de la modification de votre dépense&c=msg-error');
            exit;
        }

        $intervenant = $this->entityManager->getRepository(Intervenant::class)->find(Session::get('user')->getIdDemandeur());

        if ($intervenant == null) {
            header('Location: /?action=notes-de-frais&message=Une erreur est survenue lors de l\'ajout de votre dépense&c=msg-error');
            exit;
        }

        $depenses = $this->entityManager->getRepository(Depense::class)->findBy(['idDepense' => $arrayIds]);

        $notesDeFrais = new NoteFrais();
        $notesDeFrais->setDateNote(date('Y-m-d'));
        $notesDeFrais->setStatus('en attente');
        $notesDeFrais->setIntervenant($intervenant);
        $this->entityManager->persist($notesDeFrais);

        foreach ($depenses as $depense) {
            $depense->setNoteFrais($notesDeFrais);
            $depense->setStatus('déclarer');
            $this->entityManager->persist($depense);
        }
        $this->entityManager->flush();

        echo json_encode([
            'message' => 'Vos dépenses ont bien été déclarées',
            'success' => 'true'
        ]);
    }
}