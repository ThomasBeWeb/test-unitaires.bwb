<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatchRepository")
 */
class Match
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_match;

    /**
     * @ORM\Column(type="integer")
     */
    private $reste_places;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stade", inversedBy="listeMatchs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lieu;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Billet", mappedBy="match_id")
     */
    private $listeBillets;

    public function __construct()
    {
        $this->listeBillets = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDateMatch(): ?\DateTimeInterface
    {
        return $this->date_match;
    }

    public function setDateMatch(\DateTimeInterface $date_match): self
    {
        $this->date_match = $date_match;

        return $this;
    }

    public function getRestePlaces(): ?int
    {
        return $this->reste_places;
    }

    public function setRestePlaces(int $reste_places): self
    {
        $this->reste_places = $reste_places;

        return $this;
    }

    public function getLieu(): ?Stade
    {
        return $this->lieu;
    }

    public function setLieu(?Stade $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @return Collection|Billet[]
     */
    public function getListeBillets(): Collection
    {
        return $this->listeBillets;
    }

    public function addListeBillet(Billet $listeBillet): self
    {
        if (!$this->listeBillets->contains($listeBillet)) {
            $this->listeBillets[] = $listeBillet;
            $listeBillet->setMatchId($this);
        }

        return $this;
    }

    public function removeListeBillet(Billet $listeBillet): self
    {
        if ($this->listeBillets->contains($listeBillet)) {
            $this->listeBillets->removeElement($listeBillet);
            // set the owning side to null (unless already changed)
            if ($listeBillet->getMatchId() === $this) {
                $listeBillet->setMatchId(null);
            }
        }

        return $this;
    }
}
