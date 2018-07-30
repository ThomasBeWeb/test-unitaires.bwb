<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BilletRepository")
 */
class Billet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zone")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Spectateur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $spectateur;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_final;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TheMatch", inversedBy="listeBillets", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $rencontre;

    public function getId()
    {
        return $this->id;
    }


    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getSpectateur(): ?Spectateur
    {
        return $this->spectateur;
    }

    public function setSpectateur(?Spectateur $spectateur): self
    {
        $this->spectateur = $spectateur;

        return $this;
    }

    public function getPrixFinal(): ?float
    {
        return $this->prix_final;
    }

    public function setPrixFinal(float $prix_final): self
    {
        $this->prix_final = $prix_final;

        return $this;
    }

    public function getRencontre(): ?TheMatch
    {
        return $this->rencontre;
    }

    public function setRencontre(?TheMatch $rencontre): self
    {
        $this->rencontre = $rencontre;

        return $this;
    }
}
