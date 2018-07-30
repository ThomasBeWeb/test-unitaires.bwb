<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TheMatchRepository")
 */
class TheMatch
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stade")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lieu;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_TheMatch;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Billet", mappedBy="rencontre")
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

    public function getLieu(): ?Stade
    {
        return $this->lieu;
    }

    public function setLieu(?Stade $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDateTheMatch(): ?\DateTimeInterface
    {
        return $this->date_TheMatch;
    }

    public function setDateTheMatch(\DateTimeInterface $date_TheMatch): self
    {
        $this->date_TheMatch = $date_TheMatch;

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
            $listeBillet->setRencontre($this);
        }

        return $this;
    }

    public function removeListeBillet(Billet $listeBillet): self
    {
        if ($this->listeBillets->contains($listeBillet)) {
            $this->listeBillets->removeElement($listeBillet);
            // set the owning side to null (unless already changed)
            if ($listeBillet->getRencontre() === $this) {
                $listeBillet->setRencontre(null);
            }
        }

        return $this;
    }
}
