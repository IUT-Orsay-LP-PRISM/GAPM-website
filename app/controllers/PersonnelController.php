<?php

namespace App\controllers;

use App\models\entity\Administration;
use App\models\entity\CustomMail;
use App\models\entity\Demandeur;
use App\models\entity\Depense;
use App\models\entity\Emprunt;
use App\models\entity\Intervenant;
use App\models\entity\NoteFrais;
use App\models\entity\RendezVous;
use App\models\entity\Session;
use App\models\entity\Ville;
use App\models\repository\AdministrationRepository;
use Cassandra\Date;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PersonnelController extends Template
{
    private EntityManager $entityManager;
    private AdministrationRepository $administrationRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->administrationRepository = $entityManager->getRepository(Administration::class);
    }

    public function index(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        self::render('/personnel/home.twig', [
            'title' => 'Accueil',
            'nav' => 'home',
        ], true);
    }

    // Auth

    public function loginView(): void
    {
        if (Session::isLoggedAdmin()){
            header('Location: ./?action=home');
        }

        self::render('login.twig', [
            'title' => 'Connexion Personnel',

        ], true);
    }

    public function loginSubmit(): void
    {
        $id = $_POST['login'];
        $password = $_POST['password'];

        $isValid = !empty($id) && !empty($password);

        if ($isValid) {
            $salt = "sel";
            $saltedAndHashed = crypt($password, $salt);

            $personnelRepository = $this->entityManager->getRepository(Administration::class);
            $personnel = $personnelRepository->findOneBy([
                'login' => $id,
            ]);
            $personnelExists = !empty($personnel);

            if ($personnelExists) {
                $user = $personnel;

                if ($user->getMotDePasse() == $saltedAndHashed) {
                    $admin = new Administration();
                    $admin->setIdAdministration($personnel->getIdAdministration());
                    $admin->setLogin($id);
                    $admin->setNom($personnel->getNom());
                    $admin->setPrenom($personnel->getPrenom());
                    $admin->setEmail($personnel->getEmail());

                    Session::set('admin', $admin);

                    header('Location: ./?action=intervenants&message=Vous êtes connecté.&c=msg-success');
                } else {
                    header("Location: ./?action=login&message=Adresse email ou mot de passe incorrect.&c=msg-error");
                }
            } else {
                header("Location: ./?action=login&message=Identifiant ou mot de passe incorrect.&c=msg-error");
            }
        } else {
            header("Location: ./?action=login&message=Veuillez compléter les champs.&c=msg-warning");
        }
    }

    public function logoutSubmit(): void
    {
        Session::destroy(false);
        header('Location: ./?action=login&message=Vous êtes déconnecté.&c=msg-success');
    }

    // Intervenants
    public function intervenantsView(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        $page = $_GET['page'] ?? 0;

        $intervenantRepository = $this->entityManager->getRepository(Intervenant::class);
        $intervenants = $intervenantRepository->findAll();
        $intervenantsChunked = array_chunk($intervenants, 5);
        $intervenants = $intervenantsChunked[$page];
        $pageNumbers = count($intervenantsChunked);

        self::render('/personnel/intervenants/intervenants.twig', [
            'title' => 'Gestion des intervenants',
            'nav' => 'intervenants',
            'intervenants' => $intervenants,
            'page' => $page,
            'pageNumbers' => $pageNumbers,
            'pageDisplay' => true,
        ], true);
    }

    public function searchIntervenantsView(): void{
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        $query = $_GET['search'];

        $intervenantRepository = $this->entityManager->getRepository(Intervenant::class);
        $intervenants = $intervenantRepository->findByNameLike($query);

        self::render('/personnel/intervenants/intervenants.twig', [
            'title' => 'Gestion des intervenants',
            'nav' => 'intervenants',
            'intervenants' => $intervenants,
            'pageDisplay' => false,
        ], true);
    }

    public function intervenantView(): void{
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }
        $id = htmlspecialchars($_GET['id']);

        $intervenant = $this->entityManager->getRepository(Demandeur::class)->find($id);
        $rdvIntervenant = $intervenant->getMesRendezVous();

        $intervenant = $this->entityManager->getRepository(Intervenant::class)->findOneBy([
            'idDemandeur' => $id,
        ]);
        $notes = $this->entityManager->getRepository(NoteFrais::class)->findBy([
            'intervenant' => $intervenant->getIdDemandeur(),
        ]);

        self::render('/personnel/intervenants/intervenant.twig', [
            'title' => 'Profil de l\'intervenant ' . $intervenant->getPrenom() . ' ' . $intervenant->getNom(),
            'int' => $intervenant,
            'rdv' => $rdvIntervenant,
            'notes' => $notes,
        ], true);
    }

    public function editIntervenantView(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }
        $id = htmlspecialchars($_GET['id']);

        $intervenant = $this->entityManager->getRepository(Intervenant::class)->findOneBy([
            'idDemandeur' => $id,
        ]);

        self::render('/personnel/intervenants/edit-intervenant.twig', [
            'title' => 'Modifier l\'intervenant ' . $intervenant->getPrenom() . ' ' . $intervenant->getNom(),
            'int' => $intervenant,
        ], true);

    }

    public function deleteIntervenantView(): void{
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }
        $id = htmlspecialchars($_GET['id']);

        $intervenant = $this->entityManager->getRepository(Intervenant::class)->findOneBy([
            'idDemandeur' => $id,
        ]);

        self::render('/personnel/intervenants/delete-intervenant.twig', [
            'title' => 'Supprimer l\'intervenant',
            'id' => $id,
            'int' => $intervenant,
        ], true);
    }

    public function deleteIntervenantSubmit(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }
        $id = htmlspecialchars($_POST['id']);

        $intervenant = $this->entityManager->getRepository(Intervenant::class)->findOneBy([
            'idDemandeur' => $id,
        ]);

        // TODO: check si l'intervenant n'a pas de rdv en cours, notes de frais, véhicules etc

        try {
            $this->entityManager->remove($intervenant);
            $this->entityManager->flush();
            header('Location: ./?action=intervenants&message=Intervenant supprimé.&c=msg-success');
        } catch (OptimisticLockException|\Doctrine\ORM\Exception\ORMException $e) {
            header('Location: ./?action=intervenants&message=Erreur lors de la suppression de l\'intervenant.&c=msg-error');
        }
    }

    // Demandeurs
    public function demandeursView(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        $page = $_GET['page'] ?? 0;

        $demandeurRepository = $this->entityManager->getRepository(Demandeur::class);
        $demandeurs = $demandeurRepository->findAll();
        $demandeursNotIntervenant = [];
        foreach ($demandeurs as $demandeur){
            if (!$demandeur instanceof Intervenant){
                $demandeursNotIntervenant[] = $demandeur;
            }
        }
        $demandeursChunked = array_chunk($demandeursNotIntervenant, 6);
        $demandeurs = $demandeursChunked[$page];
        $pageNumbers = count($demandeursChunked);

        self::render('/personnel/demandeurs/demandeurs.twig', [
            'title' => 'Gestion des demandeurs',
            'nav' => 'demandeurs',
            'demandeurs' => $demandeurs,
            'page' => $page,
            'pageNumbers' => $pageNumbers,
            'pageDisplay' => true,
        ], true);
    }

    public function searchDemandeursView(): void{
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        $query = $_GET['search'];

        $demandeurRepository = $this->entityManager->getRepository(Demandeur::class);
        $demandeurs = $demandeurRepository->findByNameLike($query);

        self::render('/personnel/demandeurs/demandeurs.twig', [
            'title' => 'Gestion des demandeurs - Recherche' . $query,
            'nav' => 'demandeurs',
            'demandeurs' => $demandeurs,
            'pageDisplay' => false,
        ], true);
    }
    public function demandeurView(): void{
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }
        $id = htmlspecialchars($_GET['id']);

        $demandeur = $this->entityManager->getRepository(Demandeur::class)->findOneBy([
            'idDemandeur' => $id,
        ]);
        $rdvs = $demandeur->getRendezVous();

        self::render('/personnel/demandeurs/demandeur.twig', [
            'title' => 'Profil du demandeur ' . $demandeur->getPrenom() . ' ' . $demandeur->getNom(),
            'demandeur' => $demandeur,
            'rdv' => $rdvs,
        ], true);
    }

    public function editDemandeurView(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }
        $id = htmlspecialchars($_GET['id']);

        $dem = $this->entityManager->getRepository(Demandeur::class)->findOneBy([
            'idDemandeur' => $id,
        ]);

        self::render('/personnel/demandeurs/edit-demandeur.twig', [
            'title' => 'Modifier le demandeur : ' . $dem->getPrenom() . ' ' . $dem->getNom(),
            'dem' => $dem,
        ], true);

    }

    public function updateDemandeurSubmit(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        $id = htmlspecialchars($_POST['id']);
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $tel = htmlspecialchars($_POST['telephone']);
        $adresse = htmlspecialchars($_POST['adresse']);
        $ville = htmlspecialchars($_POST['city']);

        $demandeur = $this->entityManager->getRepository(Demandeur::class)->findOneBy([
            'idDemandeur' => $id,
        ]);
        $ville = $this->entityManager->getRepository(Ville::class)->findOneBy(['idVille' => $ville]);


        $demandeur->setNom($nom);
        $demandeur->setPrenom($prenom);
        $demandeur->setEmail($email);
        $demandeur->setTelephone($tel);
        $demandeur->setAdresse($adresse);
        $demandeur->setVille($ville);

        try {
            $this->entityManager->persist($demandeur);
            $this->entityManager->flush();
            header('Location: ./?action=demandeur-edit&id=' . $id . '&message=Demandeur modifié.&c=msg-success');
        } catch (OptimisticLockException|\Doctrine\ORM\Exception\ORMException $e) {
            header('Location: ./?action=demandeurs&message=Erreur lors de la modification du demandeur.&c=msg-error');
        }
    }

    public function deleteDemandeurView(): void{
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }
        $id = htmlspecialchars($_GET['id']);

        $demandeur = $this->entityManager->getRepository(Demandeur::class)->findOneBy([
            'idDemandeur' => $id,
        ]);

        // TODO : Vérifier que le demandeur n'a pas de rendez-vous en cours

        self::render('/personnel/demandeurs/delete-demandeur.twig', [
            'title' => 'Supprimer le demandeur : ' . $demandeur->getPrenom() . ' ' . $demandeur->getNom(),
            'id' => $id,
            'dem' => $demandeur,
        ], true);
    }

    public function deleteDemandeurSubmit(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        $id = htmlspecialchars($_POST['id']);

        $demandeur = $this->entityManager->getRepository(Demandeur::class)->findOneBy([
            'idDemandeur' => $id,
        ]);

        try {
            $this->entityManager->remove($demandeur);
            $this->entityManager->flush();
            header('Location: ./?action=demandeurs&message=Demandeur supprimé.&c=msg-success');
        } catch (OptimisticLockException|\Doctrine\ORM\Exception\ORMException $e) {
            header('Location: ./?action=demandeurs&message=Erreur lors de la suppression du demandeur.&c=msg-error');
        }
    }

    // Notes de frais
    public function notesFraisView(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        $notesFrais = $this->entityManager->getRepository(NoteFrais::class)->findBy([
            'administration' => null,
        ]);

        foreach ($notesFrais as $noteFrais) {
            $depenses = $noteFrais->getDepenses();
            $montantTotal = 0;
            foreach ($depenses as $depense) {
                $montantTotal += $depense->getMontant();
            }
            $noteFrais->setMontantTotal($montantTotal);
        }

        self::render('/personnel/notes-frais.twig', [
            'title' => 'Gestion des notes de frais',
            'nav' => 'notes',
            'notes' => $notesFrais,
        ], true);
    }

    public function noteFraisOneView(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        $id = htmlspecialchars($_GET['id']);
        $noteFrais = $this->entityManager->getRepository(NoteFrais::class)->findOneBy([
            'idNoteFrais' => $id,
        ]);

        $depenses = $noteFrais->getDepenses();
        $montantTotal = 0;
        foreach ($depenses as $depense) {
            $montantTotal += $depense->getMontant();
        }
        $noteFrais->setMontantTotal($montantTotal);

        $depenses = $this->entityManager->getRepository(Depense::class)->findBy([
            'noteFrais' => $noteFrais,
        ]);

        self::render('/personnel/notes-frais/note-frais.twig', [
            'title' => 'Note de frais n°' . $noteFrais->getIdNoteFrais(),
            'nav' => 'notes',
            'note' => $noteFrais,
            'depenses' => $depenses,
        ], true);

    }

    public function notesFraisValidateSubmit(): void
    {
        $id = htmlspecialchars($_POST['id']);

        $noteFrais = $this->entityManager->getRepository(NoteFrais::class)->findOneBy([
            'idNoteFrais' => $id,
        ]);
        $admin = $this->entityManager->getRepository(Administration::class)->findOneBy([
            'idAdministration' => Session::get('admin')->getIdAdministration(),
        ]);

        $noteFrais->setStatus('Validée');
        $noteFrais->setMessage("Note de frais validée par " . $admin->getPrenom() . " " . $admin->getNom() . ".");
        $noteFrais->setAdministration($admin);
        try {
            $this->entityManager->persist($noteFrais);
            $this->entityManager->flush();

            $referer = $_SERVER['HTTP_REFERER'];
            $referer_parts = parse_url($referer);
            $referer = $referer_parts['scheme'] . '://' . $referer_parts['host'].'/?action=notes-de-frais';

            $phpmailer = new CustomMail();
            $phpmailer->sendFrais("validée",$noteFrais,$referer);

            //send the message, check for errors
            if (!$phpmailer->send()) {
                echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
            } else {
                header('Location: ./?action=notes-frais&message=Note de frais validée.&c=msg-success');
            }
        } catch (OptimisticLockException|\Doctrine\ORM\Exception\ORMException $e) {
            header('Location: ./?action=notes-frais&message=Erreur lors de la validation de la note de frais.&c=msg-error');
        }
    }

    public function notesFraisDeniedSubmit(): void
    {
        $id = htmlspecialchars($_POST['id']);
        $message = htmlspecialchars($_POST['message']);

        $noteFrais = $this->entityManager->getRepository(NoteFrais::class)->findOneBy([
            'idNoteFrais' => $id,
        ]);
        $admin = $this->entityManager->getRepository(Administration::class)->findOneBy([
            'idAdministration' => Session::get('admin')->getIdAdministration(),
        ]);

        $noteFrais->setStatus('Refusée');
        $noteFrais->setMessage("Note de frais refusée par " . $admin->getPrenom() . " " . $admin->getNom() . ". Motif : " . $message);
        $noteFrais->setAdministration($admin);
        try {
            $this->entityManager->persist($noteFrais);
            $this->entityManager->flush();

            $referer = $_SERVER['HTTP_REFERER'];
            $referer_parts = parse_url($referer);
            $referer = $referer_parts['scheme'] . '://' . $referer_parts['host'].'/?action=notes-de-frais';

            $phpmailer = new CustomMail();
            $phpmailer->sendFrais("refusée",$noteFrais,$referer);

            //send the message, check for errors
            if (!$phpmailer->send()) {
                echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
            } else {
                header('Location: ./?action=notes-frais&message=Note de frais refusée.&c=msg-success');
            }
        } catch (OptimisticLockException|\Doctrine\ORM\Exception\ORMException $e) {
            header('Location: ./?action=notes-frais&message=Erreur lors du refus de la note de frais.&c=msg-error');
        }
    }

    // Emprunts de véhicules
    public function empruntsVehiculesView(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        $emprunts = $this->entityManager->getRepository(Emprunt::class)->findBy([
            'administration' => null,
        ]);
        self::render('/personnel/emprunts.twig', [
            'title' => 'Gestion des emprunts de véhicules',
            'nav' => 'vehicles',
            'emprunts' => $emprunts,
        ], true);
    }

    public function empruntsVehiculesValidateSubmit(): void
    {
        $id = htmlspecialchars($_POST['id']);

        $emprunt = $this->entityManager->getRepository(Emprunt::class)->findOneBy([
            'idEmprunt' => $id,
        ]);
        $admin = $this->entityManager->getRepository(Administration::class)->findOneBy([
            'idAdministration' => Session::get('admin')->getIdAdministration(),
        ]);

        $emprunt->setAdministration($admin);
        try {
            $this->entityManager->persist($emprunt);
            $this->entityManager->flush();

            $referer = $_SERVER['HTTP_REFERER'];
            $referer_parts = parse_url($referer);
            $referer = $referer_parts['scheme'] . '://' . $referer_parts['host'].'/?action=my-account';

            $phpmailer = new CustomMail();
            $phpmailer->sendVoiture("validé",$emprunt,$referer);

            if (!$phpmailer->send()) {
                echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
            } else {
                header('Location: ./?action=emprunts&message=Emprunt validé.&c=msg-success');
            }
        } catch (OptimisticLockException|\Doctrine\ORM\Exception\ORMException $e) {
            header('Location: ./?action=emprunts&message=Erreur lors de la validation de l\'emprunt.&c=msg-error');
        }
    }

    public function empruntsVehiculesDeniedSubmit(): void
    {
        $id = htmlspecialchars($_POST['id']);

        $emprunt = $this->entityManager->getRepository(Emprunt::class)->findOneBy([
            'idEmprunt' => $id,
        ]);

        try {
            $this->entityManager->remove($emprunt);
            $this->entityManager->flush();

            $referer = $_SERVER['HTTP_REFERER'];
            $referer_parts = parse_url($referer);
            $referer = $referer_parts['scheme'] . '://' . $referer_parts['host'].'/?action=my-account';

            $phpmailer = new CustomMail();
            $phpmailer->sendVoiture("refusé",$emprunt,$referer);

            if (!$phpmailer->send()) {
                echo 'Mailer Error: ' . $phpmailer->ErrorInfo;
            } else {
                header('Location: ./?action=emprunts&message=Emprunt refusé.&c=msg-success');
            }
        } catch (OptimisticLockException|\Doctrine\ORM\Exception\ORMException $e) {
            header('Location: ./?action=emprunts&message=Erreur lors du refus de l\'emprunt.&c=msg-error');
        }
    }

    public function cessationView(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }
        $cessations = $this->entityManager->getRepository(Intervenant::class)->findBy([
            'demandeSupp' => 1,
        ]);

        self::render('/personnel/cessation.twig', [
            'title' => 'Demande de cessation d\'activité',
            'nav' => 'activity',
            'intervenants' => $cessations,
        ], true);

    }



}