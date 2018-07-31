<?php
namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Traitements\Calculs;
use App\Entity\Billet;
use App\Entity\Stade;
use App\Entity\Spectateur;
use App\Entity\Zone;
use App\Entity\Role;
use App\Entity\Abonnement;
use App\Entity\TheMatch;

class TestCalculs extends TestCase
{

    public $calculs;
    public $billet;
    public $stade;
    public $spectateur;
    public $zone;
    public $role;
    public $abo;
    public $theMatch;

    protected function setUp(){
        parent::setUp();

        $this->calculs = new Calculs();
        $this->billet = new Billet();
        $this->stade = new Stade();
        $this->theMatch = new TheMatch();
        $this->spectateur = new Spectateur();
        $this->zone = new Zone();
        $this->role = new Role();
        $this->abo = new Abonnement();

        $this->stade->setNbPlaces(500)
        ->setPrixPlace(50)
        ->setPrixAbonnement(250)
        ->setReducAbonnement(20)
        ->setPrixEnfant(10)
        ->setReducEtudiant(75)
        ;

        $this->role->setNom("enfant");

        $this->abo->setDateDebut(date_create_from_format('Y-m-d', '2012-10-15'));
        $this->abo->setDateFin(date_create_from_format('Y-m-d', '2012-10-15'));

        $this->spectateur->setRole($this->role);
        $this->spectateur->setAbonnement($this->abo);

        $this->theMatch->setLieu($this->stade);

        $this->billet->setZone($this->zone);
        $this->billet->setSpectateur($this->spectateur);
        $this->billet->setRencontre($this->theMatch);

    }

    public function testAbo() {
        $this->zone->setMalus(10);
        $this->assertEquals(10,$this->calculs->getPrixBillet($this->billet));
    }
}