<?php

namespace App\controllers;

use App\models\entity\Administration;
use App\models\entity\Demandeur;
use App\models\entity\Depense;
use App\models\entity\Intervenant;
use App\models\entity\NoteFrais;
use App\models\entity\Session;
use App\models\entity\Ville;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use function Symfony\Component\String\u;

class PersonnelController extends Template
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
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
                    Session::set('admin', $user);

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

    public function notesFraisView(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        self::render('/personnel/notes-frais.twig', [
            'title' => 'Gestion des notes de frais',
            'nav' => 'notes',
        ], true);
    }

    public function empruntsVehiculesView(): void
    {
        if (!Session::isLoggedAdmin()){
            header('Location: ./?action=login');
        }

        self::render('/personnel/emprunts.twig', [
            'title' => 'Gestion des emprunts de véhicules',
            'nav' => 'vehicles',
        ], true);
    }

}