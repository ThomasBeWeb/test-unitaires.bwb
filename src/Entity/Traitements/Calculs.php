<?php

namespace App\Entity\Traitements;

use Doctrine\ORM\Mapping as ORM;

class Calculs {

    public function getPrixBillet($billet){

        //Stade: Prix de base
        $prixBase = $billet->getRencontre()->getLieu()->getPrixPlace();

        //Stade: Reduc Abonnement
        $reducAbo = $billet->getRencontre()->getLieu()->getReducAbonnement();

        //Stade: Reduc Etudiant
        $reducEtu = $billet->getRencontre()->getLieu()->getReducEtudiant();

        //Stade: Prix enfant
        $prixEnfant = $billet->getRencontre()->getLieu()->getPrixEnfant();

        //Spectateur: Role
        $role = $billet->getSpectateur()->getRole()->getNom();

        // //Spectateur: Abonnement
        // $abo = $billet->getSpectateur()->getAbonnement();

        //Zone
        $zone = $billet->getZone();


        //Calcul du prix en fontion de la zone
        $prix = $prixBase + ($prixBase * $zone->getMalus() / 100);


        //Application reduction si besoin
        switch($role){

            case "abonné":
                $prix = $prix * (1 - $reducAbo / 100);
                break;

            case "étudiant":
                $prix = $prix * (1 - $reducEtu / 100);
                break;

            case "enfant":
                $prix = $prixEnfant;
                break;

            default:
                break;
        }

        return $prix;
    }

}

