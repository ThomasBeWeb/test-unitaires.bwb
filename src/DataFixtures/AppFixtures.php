<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Abonnement;
use App\Entity\Billet;
use App\Entity\TheMatch;
use App\Entity\Role;
use App\Entity\Spectateur;
use App\Entity\Stade;
use App\Entity\Zone;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager){

        $this->makeRoles($manager);
        $this->makeStade($manager);
        $this->makeSpectateurs($manager);
        $this->makeZones($manager);
        $this->makeMatches($manager);
        $this->makeBillets($manager);
    }

    public function makeRoles(ObjectManager $manager){

        $listeName =["base","abonné","étudiant","enfant"];
        $listePourcentage = [null,20,75,null];
        $listePrixFixe = [null,null,null,10];

        for($i = 0 ; $i < count($listeName) ; $i++){

            $newObj = (new Role())
                ->setNom($listeName[$i])
                ->setPourcentage($listePourcentage[$i])
                ->setPrixFixe($listePrixFixe[$i])
            ;
            $manager->persist($newObj);
        }

        $manager->flush();
    }

    public function makeStade(ObjectManager $manager){

        $newObj = (new Stade())
            ->setNbPlaces(30)
            ->setPrixPlace(50)
            ->setPrixAbonnement(250)
            ->setReducAbonnement(20)
            ->setPrixEnfant(10)
            ->setReducEtudiant(20)
        ;

        $manager->persist($newObj);

        $manager->flush();
    }

    public function makeSpectateurs(ObjectManager $manager){

        $datesDebut = ["2017-09-12","2017-08-15","2017-09-01","2017-08-01"];
        $datesFin = ["2018-09-12","2018-08-15","2018-09-01","2018-08-01"];

        for($i = 0 ; $i < 1000 ; $i++){

            $randomRole = \random_int(1,4);

            $newObj = (new Spectateur())->setRole($manager->find(Role::class, $randomRole));

            if($randomRole === 1){  //Abonné

                //Creation d'un abonnement
                
                $randomListeDates = \random_int(0,3);
                
                $newAbonnement = (new Abonnement())
                ->setDateDebut(date_create_from_format('Y-m-d', $datesDebut[$randomListeDates]))
                ->setDateFin(date_create_from_format('Y-m-d', $datesFin[$randomListeDates]))
                ;
                
                $manager->persist($newAbonnement);

                $manager->flush();

                $newObj->setAbonnement($newAbonnement);
            }
            $manager->persist($newObj);
        }
        
        $manager->flush();
        
    }

    public function makeZones(ObjectManager $manager){

        $listeNiveaux =[1,2,3,4,5];
        $listeMalus = [0,10,15,20,25];

        for($i = 0 ; $i < count($listeNiveaux) ; $i++){

            $newObj = (new Zone())
                ->setNiveau($listeNiveaux[$i])
                ->setMalus($listeMalus[$i])
            ;
            $manager->persist($newObj);
        }

        $manager->flush();
    }

    public function makeMatches(ObjectManager $manager){

        $listeDates = ['2017-09-19','2017-09-06','2017-11-09','2017-10-03','2017-08-25','2017-12-18','2018-03-11','2018-02-17','2017-11-05','2018-05-30','2017-12-13','2018-04-29','2017-09-16','2017-11-08','2018-03-26','2018-03-27','2018-01-21','2017-10-23','2018-03-19','2017-11-13','2018-04-17','2017-12-02','2018-06-07','2018-04-19','2017-10-19','2018-02-01','2017-11-21','2018-02-18','2017-09-22','2017-08-05','2018-06-29','2017-12-25','2017-09-02','2018-01-07','2017-10-01','2018-04-13','2018-03-06','2017-12-23','2017-12-21','2017-11-28'];

        for($i = 0 ; $i < count($listeDates); $i++){

            $newObj = (new TheMatch())
                ->setDateTheMatch(date_create_from_format('Y-m-d', $listeDates[$i]))
                ->setLieu($manager->find(Stade::class, 1))
            ;
            $manager->persist($newObj);
        }

        $manager->flush();
    }

    public function makeBillets(ObjectManager $manager){

        $stade = $manager->find(Stade::class, 1);

        $prix_place = $stade->getPrixPlace();

        for($i = 0 ; $i < 1200 ; $i++){

            //Spectateur
            $randomSpectateur = $manager->find(Spectateur::class, \random_int(1,1000));

            //Zone
            $randomZone = $manager->find(Zone::class, \random_int(1,5));

            //Match
            $verif = true;
            $newMatch;

            while($verif){

                $newMatch = $manager->find(TheMatch::class, \random_int(1,40));

                if(count($newMatch->getListeBillets()) < $stade->getNbPlaces()) {
                    $verif = false;
                }
            }

            $prix = $prix_place + ($prix_place * $randomZone->getMalus() / 100);

            switch($randomSpectateur->getRole()->getNom()){

                case "abonné":
                    $prix = $prix * (1 - $stade->getReducAbonnement() / 100);
                    break;

                case "étudiant":
                    $prix = $prix * (1 - $stade->getReducEtudiant() / 100);
                    break;

                case "enfant":
                    $prix = $stade->getPrixEnfant();
                    break;

                default:
                    break;
            }

            $newObj = (new Billet())
                ->setZone($randomZone)
                ->setSpectateur($randomSpectateur)
                //->setRencontre($newMatch)
                ->setPrixFinal($prix)
            ;

            $newMatch->addListeBillet($newObj);
            
            $manager->persist($newObj);
            $manager->flush();
        }

    }

    //SELECT rencontre_id, COUNT(spectateur_id) FROM `billet` GROUP BY rencontre_id
}
