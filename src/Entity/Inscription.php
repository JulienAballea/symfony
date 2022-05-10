<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Personne;
use App\Entity\Trajet;

/**
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 */
class Inscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\ManyToOne(targetEntity="Personne")
    * @ORM\JoinColumn(name="personne_id", referencedColumnName="id")
    */
    private Personne $personne;

    /**
    * @ORM\ManyToOne(targetEntity="Trajet")
    * @ORM\JoinColumn(name="trajet_id", referencedColumnName="id")
    */
    private Trajet $trajet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): self
    {
        $this->personne = $personne;

        return $this;
    }

    public function getTrajet(): ?Trajet
    {
        return $this->trajet;
    }

    public function setTrajet(?Trajet $trajet): self
    {
        $this->trajet = $trajet;

        return $this;
    }
}
