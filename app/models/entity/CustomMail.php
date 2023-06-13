<?php

namespace App\models\entity;

use App\models\entity\Demandeur;
use App\models\entity\Intervenant;
use App\models\entity\RendezVous;
use App\models\entity\Emprunt;
use App\models\entity\Voiture;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class CustomMail extends PHPMailer
{
    function sendMdp($email,$demandeur,$newMdp){
        $this->addAddress($email, $demandeur->getNom() . ' ' . $demandeur->getPrenom());
        $this->Subject = 'Mot de passe oublié';
        $this->Body = 'Voici votre mot de passe temporaire : ' . $newMdp;
    }

    function sendCancelRdv($acteur,$demandeur,$intervenant,$rdv,$referer){
        $this->addAddress($demandeur->getEmail(), $demandeur->getNom() . ' ' . $demandeur->getPrenom());
        $this->addAddress($intervenant->getEmail(), $intervenant->getNom() . ' ' . $intervenant->getPrenom());
        $this->Subject = 'Annulation du rendez-vous';
        $this->Body = 'Le rendez-vous du ' . $rdv->getDateRdv() . ' de ' . $rdv->getHeureDebut() . ' à ' . $rdv->getHeureFin() .
        ', demandé par ' . $demandeur->getPrenom() . ' ' . $demandeur->getNom() . ' avec ' . $intervenant->getPrenom() . ' '
        . $intervenant->getNom() . ', a été annulé par '.$acteur.'.<br>

Pour voir vos rendez-vous, cliquez ici : <a href="'. $referer .'">Voir mes rendez-vous</a>';
    }

    function sendRdv($demandeur,$intervenant,$rdv,$referer){
        $this->addAddress($demandeur->getEmail(), $demandeur->getNom() . ' ' . $demandeur->getPrenom());
        $this->addAddress($intervenant->getEmail(), $intervenant->getNom() . ' ' . $intervenant->getPrenom());
        $this->Subject = 'Confirmation d\'un rendez-vous';
        $this->Body = 'Le rendez-vous du ' . $rdv->getDateRdv() . ' de ' . $rdv->getHeureDebut() .' à '. $rdv->getHeureFin() .
        ', demandé par ' . $demandeur->getPrenom() . ' ' . $demandeur->getNom() .' avec ' .$intervenant->getPrenom() .' '
        . $intervenant->getNom() .', a bien été pris en compte.<br>

Pour voir vos rendez-vous, cliquez ici : <a href="'. $referer .'">Voir mes rendez-vous</a>';
    }

    function sendCommentaire($demandeur,$intervenant,$rdv,$referer){
        $this->addAddress($demandeur->getEmail(), $demandeur->getNom() . ' ' . $demandeur->getPrenom());
        $this->addAddress($intervenant->getEmail(), $intervenant->getNom() . ' ' . $intervenant->getPrenom());
        $this->Subject = 'Commentaire d\'un Rendez-vous';
        $this->Body = 'Le rendez-vous du ' . $rdv->getDateRdv() . ' de ' . $rdv->getHeureDebut() .' à '. $rdv->getHeureFin() .
        ', demandé par ' . $demandeur->getPrenom() . ' ' . $demandeur->getNom() .' avec ' .$intervenant->getPrenom() .' '
        . $intervenant->getNom() .', à recu un commentaire.<br>

Pour voir vos rendez-vous, cliquez ici : <a href="'. $referer .'">Voir les rendez-vous</a>';
    }

    function sendVoiture($action,$emprunt,$referer){
        $intervenant = $emprunt->getIntervenant();
        $voiture = $emprunt->getVoiture();
        $this->addAddress($intervenant->getEmail(), $intervenant->getNom() . ' ' . $intervenant->getPrenom());
        if($action == "validé"){
            $this->Subject = 'Validation d\'un emprunt';
        }
        else{
            $this->Subject = 'Refus d\'un emprunt';
        }
        $this->Body = 'Votre demande d\'emprunt de vehicule du '.$emprunt->getDateDebut().' au '.$emprunt->getDateFin().' pour une '.$voiture->getTypeVoiture()->getMarque().' '.$voiture->getTypeVoiture()->getModele().' a été '.$action.' par un administrateur.<br>

Pour voir vos emprunts, cliquez ici : <a href="'. $referer .'">Voir les emprunts</a>';
    }

    function sendFrais($action,$noteFrais,$referer){
        $intervenant = $noteFrais->getIntervenant();
        $this->addAddress($intervenant->getEmail(), $intervenant->getNom() . ' ' . $intervenant->getPrenom());
        if($action == "validée"){
            $this->Subject = 'Validation d\'une note de frais';
        }
        else{
            $this->Subject = 'Refus d\'une note de frais';
            $action .= ' pour la raison : '.$noteFrais->getMessage();
        }
        $this->Body = 'Votre note de frais du '. $noteFrais->getDateNote() .' pour un montant total de '. $noteFrais->getMontantTotal() .' a recu une nouvelle action.<br>
'. $noteFrais->getMessage() .'<br>

Pour voir vos notes de frais, cliquez ici : <a href="'. $referer .'">Voir les notes de frais</a>';
    }

    function sendCancelFrais($email,$demandeur,$newMdp){
        $this->addAddress($email, $demandeur->getNom() . ' ' . $demandeur->getPrenom());
        $this->Subject = 'Mot de passe oublié';
        $this->Body = 'Voici votre mot de passe temporaire : ' . $newMdp;
    }

    function __construct(){
        $this->isSMTP();
        $this->Host = 'smtp.local';
        $this->CharSet = "UTF-8";
        $this->SMTPAuth = true;
        $this->Port = 2525;
        $this->Username = '87aafa94a4e2c8';
        $this->Password = '2b192b0e9179d3';
        $this->setFrom('no-reply@gapm.com', 'No-reply');
    }

    function send(){
        return true;
    }
}