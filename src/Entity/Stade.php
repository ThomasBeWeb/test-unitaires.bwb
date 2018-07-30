<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StadeRepository")
 */
class Stade
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_places;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_place;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_abonnement;

    /**
     * @ORM\Column(type="float")
     */
    private $reduc_abonnement;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix_enfant;

    /**
     * @ORM\Column(type="integer")
     */
    private $reduc_etudiant;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Match", mappedBy="lieu")
     */
    private $listeMatchs;

    public function __construct()
    {
        $this->listeMatchs = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNbPlaces(): ?int
    {
        return $this->nb_places;
    }

    public function setNbPlaces(int $nb_places): self
    {
        $this->nb_places = $nb_places;

        return $this;
    }

    public function getPrixPlace(): ?float
    {
        return $this->prix_place;
    }

    public function setPrixPlace(float $prix_place): self
    {
        $this->prix_place = $prix_place;

        return $this;
    }

    public function getPrixAbonnement(): ?float
    {
        return $this->prix_abonnement;
    }

    public function setPrixAbonnement(float $prix_abonnement): self
    {
        $this->prix_abonnement = $prix_abonnement;

        return $this;
    }

    public function getReducAbonnement(): ?int
    {
        return $this->reduc_abonnement;
    }

    public function setReducAbonnement(int $reduc_abonnement): self
    {
        $this->reduc_abonnement = $reduc_abonnement;

        return $this;
    }

    public function getPrixEnfant(): ?float
    {
        return $this->prix_enfant;
    }

    public function setPrixEnfant(float $prix_enfant): self
    {
        $this->prix_enfant = $prix_enfant;

        return $this;
    }

    public function getReducEtudiant(): ?int
    {
        return $this->reduc_etudiant;
    }

    public function setReducEtudiant(int $reduc_etudiant): self
    {
        $this->reduc_etudiant = $reduc_etudiant;

        return $this;
    }

    /**
     * @return Collection|Match[]
     */
    public function getListeMatchs(): Collection
    {
        return $this->listeMatchs;
    }

    public function addListeMatch(Match $listeMatch): self
    {
        if (!$this->listeMatchs->contains($listeMatch)) {
            $this->listeMatchs[] = $listeMatch;
            $listeMatch->setLieu($this);
        }

        return $this;
    }

    public function removeListeMatch(Match $listeMatch): self
    {
        if ($this->listeMatchs->contains($listeMatch)) {
            $this->listeMatchs->removeElement($listeMatch);
            // set the owning side to null (unless already changed)
            if ($listeMatch->getLieu() === $this) {
                $listeMatch->setLieu(null);
            }
        }

        return $this;
    }
}
