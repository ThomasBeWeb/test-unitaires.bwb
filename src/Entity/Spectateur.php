<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpectateurRepository")
 */
class Spectateur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Abonnement", cascade={"persist", "remove"})
     */
    private $abonnement;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Billet", mappedBy="spectateur")
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

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getAbonnement(): ?Abonnement
    {
        return $this->abonnement;
    }

    public function setAbonnement(?Abonnement $abonnement): self
    {
        $this->abonnement = $abonnement;

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
            $listeBillet->setSpectateur($this);
        }

        return $this;
    }

    public function removeListeBillet(Billet $listeBillet): self
    {
        if ($this->listeBillets->contains($listeBillet)) {
            $this->listeBillets->removeElement($listeBillet);
            // set the owning side to null (unless already changed)
            if ($listeBillet->getSpectateur() === $this) {
                $listeBillet->setSpectateur(null);
            }
        }

        return $this;
    }
}
